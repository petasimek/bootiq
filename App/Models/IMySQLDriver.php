<? declare(strict_types=1);

namespace App\Models;

interface IMySQLDriver
{
	/**
	 * @param string $id
	 * @return array
	 */
	public function findProductId(string $id): array;
}