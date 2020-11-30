<? declare(strict_types=1);

namespace App\Models;

interface IElasticSearchDriver
{
	/**
	 * @param string $id
	 * @return array
	 */
	public function findById(string $id): array;
}