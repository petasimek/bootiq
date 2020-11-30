<? declare(strict_types=1);

namespace App\Controllers;

use App\Models\CacheDriver;
use App\Models\Storages\FileStorage;

class BaseController extends IController
{
	/** @var CacheDriver */
	private $cacheDriver;


	public function __construct()
	{
		parent::__construct();
		$this->cacheDriver = new CacheDriver(new FileStorage('./temp/cache/'));
	}

	public function getProductCache(): CacheDriver
	{
		return $this->cacheDriver;
	}
}