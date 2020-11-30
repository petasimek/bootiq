<? declare(strict_types=1);
	
namespace App\Models\Storages;

use App\Models\IStorage;

class FileStorage implements IStorage
{
	/** @var string */
	private $dir;


	public function __construct(string $dir)
	{
		$this->dir = $dir;
	}

	public function read(string $key): array
	{
		$result = [];
		$path = $this->dir.$key;
		if (\file_exists($path)) {
			$result = \json_decode(\file_get_contents($path));
		}

		return $result;
	}

	public function remove(string $key): void
	{
		$path = $this->dir.$key;
		if (\file_exists($path)) {
			\unlink($path);
		}
	}

	public function write(string $key, array $data): void
	{
		$path = $this->dir.$key;
		\file_put_contents($path, \json_encode($data));
	}
}