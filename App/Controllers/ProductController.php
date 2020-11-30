<? declare(strict_types=1);

namespace App\Controllers;

use App\Models\IElasticSearchDriver;
use App\Models\IMySQLDriver;
use App\Models\CacheDriver;

class ProductController extends BaseController
{
	const CACHE_PRODUCT_KEY = 'product_';
	const CACHE_PRODUCT_COUNTER_KEY = 'product_counter';
	
	/** @var IElasticSearchDriver */
	private $elasticSearchDriver;
	
	/** @var IMySQLDriver */
	private $mySQLDriver;

	/** @var CacheDriver */
	private $cacheDriver;


	public function __construct(
		IElasticSearchDriver $elasticSearchDriver,
		IMySQLDriver $mySQLDriver
	) {
		parent::__construct();
		$this->elasticSearchDriver = $elasticSearchDriver;
		$this->mySQLDriver = $mySQLDriver;
		$this->cacheDriver = $this->getProductCache();
	}
	
	/**
	 * @param string $id
	 * @return string
	 */
	public function detail(string $id): string
	{
		//find product in cache
		$product = $this->cacheDriver->read(self::CACHE_PRODUCT_KEY.$id);
		if(empty($product)) {
			$product = $this->elasticSearchDriver->findById($id);
			if (empty($product)) {
				$product = $this->mySQLDriver->findProductId($id);
			}
			
			if (empty($product)) {
				$this->cacheDriver->write(self::CACHE_PRODUCT_KEY . $id, $product);
			}
		}

		//if product exists, inc counter
		if (empty($product)) {
			$productCounter = $this->cacheDriver->read(self::CACHE_PRODUCT_COUNTER_KEY);
			if(empty($productCounter)) {
				$productCounter = [];
			} else if (\key_exists($id, $productCounter) === false) {
				$productCounter[$id] = 1;
			} else {
				$productCounter[$id] += 1;
			}

			$this->cacheDriver->write(self::CACHE_PRODUCT_COUNTER_KEY, $productCounter);
		}

		return \json_encode($product);
	}
}