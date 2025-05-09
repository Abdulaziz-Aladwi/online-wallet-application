<?php

namespace Tests\Unit\Services\Webhooks;

use App\DTOs\ParsedTransactionDto;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Webhooks\CreateTransactionService;
use DateTime;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\Lock;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Tests\TestCase;

class CreateTransactionServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private CreateTransactionService $service;
    private TransactionRepositoryInterface $transactionRepository;
    private UserRepositoryInterface $userRepository;
    private CacheManager $cacheManager;
    private Lock $lock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transactionRepository = Mockery::mock(TransactionRepositoryInterface::class);
        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->cacheManager = Mockery::mock(CacheManager::class);
        $this->lock = Mockery::mock(Lock::class);

        $this->service = new CreateTransactionService(
            $this->transactionRepository,
            $this->cacheManager,
            $this->userRepository
        );
    }

    public function test_execute_creates_transaction_successfully()
    {
        $user = Mockery::mock(User::class);
        $user->shouldReceive('getAttribute')->with('id')->andReturn(1);
        
        $transactionDto = new ParsedTransactionDto(
            reference: 'test-ref-123',
            amount: 100.00,
            date: new DateTime('2024-03-20'),
            meta: [],
            bank_type: 22
        );

        $expectedTransaction = new Transaction([
            'user_id' => 1,
            'reference' => 'test-ref-123',
            'amount' => 100.00,
            'date' => new DateTime('2024-03-20'),
            'bank_type' => 22
        ]);

        $this->userRepository
            ->shouldReceive('first')
            ->once()
            ->andReturn($user);

        $this->cacheManager
            ->shouldReceive('lock')
            ->with('transaction:test-ref-123', 10)
            ->once()
            ->andReturn($this->lock);

        $this->lock
            ->shouldReceive('block')
            ->with(5, Mockery::any())
            ->once()
            ->andReturnUsing(function ($timeout, $callback) use ($expectedTransaction) {
                return $callback();
            });

        $this->transactionRepository
            ->shouldReceive('firstOrCreate')
            ->with(
                ['user_id' => 1, 'reference' => 'test-ref-123'],
                [
                    'amount' => 100.00,
                    'date' => new DateTime('2024-03-20'),
                    'meta' => [],
                    'bank_type' => 22
                ]
            )
            ->once()
            ->andReturn($expectedTransaction);

        $result = $this->service->execute($transactionDto);
        $this->assertEquals($expectedTransaction, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
