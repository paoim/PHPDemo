<?php

class DoubleDecliningBalanceDepreciation
{
	private $_salvageValue;
	
	private $_purchasePrice;
	
	private $_depreciationPeriod;
	
	public function __construct($salvageValue, $purchasePrice, $depreciationPeriod)
	{
		$this->_salvageValue = $salvageValue;
		$this->_purchasePrice = $purchasePrice;
		$this->_depreciationPeriod = $depreciationPeriod;
	}
	
	public function calculateDepreciation()
	{
		$totalCumulative = 0;
		$oldTotalCumulative = 0;
		$bookValueEnd = $this->_purchasePrice;
		$straightLineDepreciationRate = (1/$this->_depreciationPeriod); // 1/n where n is Depreciation Period
		$decliningBalanceRate = 2 * $straightLineDepreciationRate; // 2 × Straight Line Rate [Depreciation Rate]
		
		for ($j = 1; $j <= $this->_depreciationPeriod; $j++) {
			$bookValueStart = $bookValueEnd;
			$oldTotalCumulative = $totalCumulative;
			$depreciation = $decliningBalanceRate * $bookValueStart; // Depreciation Rate[2 × Straight Line Rate] × Book Value of Asset [Book value at the beginning of the year]
			$totalCumulative = $depreciation + $totalCumulative;
			$bookValueEnd = $bookValueStart - $depreciation;
			
			$this->_show('Year: ' .$j);
			$this->_show('DecliningBalanceRate: ' .$decliningBalanceRate);
			$this->_show('OldCumulative: ' .$oldTotalCumulative);
			$this->_show('--------------------------------------------------------------------------');
		
			if ($bookValueEnd < $this->_salvageValue) {
		
				$bookValueEnd = $this->_salvageValue;
				//$decliningBalanceRate = 1 - ($this->_salvageValue / $bookValueStart);
				//$depreciation = $decliningBalanceRate * $bookValueStart;
				$depreciation = $bookValueStart - $this->_salvageValue;
				$totalCumulative = $depreciation + $oldTotalCumulative;
		
				$this->_show('BookValueStart: ' .$bookValueStart);
				$this->_show('DepreciationExspense: ' .$depreciation);
				$this->_show('Cumulative: ' .$totalCumulative);
				$this->_show('BookValueEnd: ' .$bookValueEnd);
				$this->_show('======================================Special=====================================');
				break;
			} else {
				$this->_show('BookValueStart: ' .$bookValueStart);
				$this->_show('DepreciationExspense: ' .$depreciation);
				$this->_show('Cumulative: ' .$totalCumulative);
				$this->_show('BookValueEnd: ' .$bookValueEnd);
				$this->_show('===========================================================================');
			}
		}
	}
	
	private function _show($data)
	{
		echo "<pre>"; print_r($data); echo "</pre>";
	}
}
