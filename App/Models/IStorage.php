<? declare(strict_types=1);

namespace App\Models;

interface IStorage
{
	/**
	 * Read from cache.
	 * @param  string $key
	 * @return string|null
	 */
	public function read(string $key): ?string;
	
	/**
	 * Writes item into the cache.
	 * @param  string $key
	 * @param  array $data
	 * @return void
	 */
	public function write(string $key, array $data): void;
	
	/**
	 * Removes item from the cache.
	 * @param  string $key
	 * @return void
	 */
	public function remove(string $key): void;
}