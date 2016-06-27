<?
namespace Silversite\Toolkit;

Class SimilarOffer {
	protected $arLW = array();
	protected $startLWValue = "";
	protected $direction = "";
	protected $arDirections = array("plus", "minus");
	protected $iterator = 1;
	protected $plusEnded = false;
	protected $minusEnded = false;
	protected $functionInvokeCount = 0;
	protected $LWkey = 0;

	public function __construct($arLW, $lengthValue = 200, $widthValue = 160, $direction = "plus")
	{
		$this->arLW = $arLW;
		$this->startLWValue = $lengthValue."x".$widthValue;
		$this->direction = $direction;
		$this->LWKey = array_search($this->startLWValue, $this->arLW);
	}

	public function getSimilarOffer($product)
	{
		//Направление итерации
		if(!in_array($this->direction, $this->arDirections))
			$this->direction = "plus";


		//Изменение ключа
		$LWKey = $this->changeKey();
		//Увеличиваем счетчик выполнения функции
		$this->functionInvokeCount++;
		//Поменять направление проверки
		$this->changeDirection();
		//Увеличить итератор после 2х выполнений
		if($this->functionInvokeCount == 2)
		{
			$this->iterator++;
			//Сбрасываем счетчик выполнения функции
			$this->functionInvokeCount = 0;
		}

		$lwKeyValue = $this->arLW[$LWKey];
		if(isset($product["OFFERS"][$lwKeyValue]))
			return $product["OFFERS"][$lwKeyValue];
		elseif($this->plusEnded && $this->minusEnded)
			//Не удалось ничего найти
			return 0;
		else
			return $this->getSimilarOffer($product, $LWKey);
	}

	function changeKey()
	{
		switch($this->direction) {
			case "plus":
				if(!$this->plusEnded)
				{
					if(($this->LWKey + $this->iterator) < (count($this->arLW)))
						return $this->LWKey + $this->iterator;
					else
						$this->plusEnded = true; //Дошел до 0 элемента массива
				}
				break;
			case "minus":
				if(!$this->minusEnded)
				{
					if(($this->LWKey - $this->iterator) >= 0)
						return $this->LWKey - $this->iterator;
					else
						$this->minusEnded = true; //Дошел до последнего элемента массива
				}
				break;
		}
		return 0;
	}

	public function changeDirection()
	{
		if($this->direction == $this->arDirections[0])
			$this->direction = $this->arDirections[1];
		else
			$this->direction = $this->arDirections[0];
	}

}