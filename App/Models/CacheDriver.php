<? declare(strict_types=1);

namespace App\Models;

class CacheDriver
{
	/** @var IStorage */
	private $storage;


	public function __construct(IStorage $storage)
	{
		$this->storage = $storage;
	}

	public function getStorage(): IStorage
	{
		return $this->storage;
	}

	public function setStorage(IStorage $storage): void
	{
		$this->storage = $storage;
	}
	
	public function read(string $key): array
	{
		return $this->storage->read(\md5($key));
	}
	
	public function remove(string $key): void
	{
		$this->storage->remove(\md5($key));
	}
	
	public function write(string $key, array $data): void
	{
		$this->storage->write(\md5($key), $data);
	}
}