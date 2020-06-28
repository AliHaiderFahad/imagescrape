<?php

 /**
	*	Function accepts either 12 or 13 digit number, and either provides or checks the validity of the 13th checksum digit
	*    Optionally converts to ISBN 10 as well.
	*/
	function isbn13checker($input, $convert = FALSE){
		$output = FALSE;
		if (strlen($input) < 12){
			$output = array('error'=>'ISBN too short.');
		}
		if (strlen($input) > 13){
			$output = array('error'=>'ISBN too long.');
		}
		if (!$output){
			$runningTotal = 0;
			$r = 1;
			$multiplier = 1;
			for ($i = 0; $i < 13 ; $i++){
				$nums[$r] = substr($input, $i, 1);
				$r++;
			}
			$inputChecksum = array_pop($nums);
			foreach($nums as $key => $value){
				$runningTotal += $value * $multiplier;
				$multiplier = $multiplier == 3 ? 1 : 3;
			}
			$div = $runningTotal / 10;
			$remainder = $runningTotal % 10;

			$checksum = $remainder == 0 ? 0 : 10 - substr($div, -1);

			$output = array('checksum'=>$checksum);
			$output['isbn13'] = substr($input, 0, 12) . $checksum;
			if ($convert){
				$output['isbn10'] = isbn13to10($output['isbn13']);
			}
			if (is_numeric($inputChecksum) && $inputChecksum != $checksum){
				$output['error'] = 'Input checksum digit incorrect: ISBN not valid';
				$output['input_checksum'] = $inputChecksum;
			}
		}
		return $output;
	}

	/**
	*	Function accepts either 10 or 9 digit number, and either provides or checks the validity of the 10th checksum digit
	*    Optionally converts to ISBN 13 as well.
	*/
	function isbn10checker($input, $convert = FALSE){
		$output = FALSE;
		if (strlen($input) < 9){
			$output = array('error'=>'ISBN too short.');
		}
		if (strlen($input) > 10){
			$output = array('error'=>'ISBN too long.');
		}
		if (!$output){
			$runningTotal = 0;
			$r = 1;
			$multiplier = 10;
			for ($i = 0; $i < 10 ; $i++){
				$nums[$r] = substr($input, $i, 1);
				$r++;
			}
			$inputChecksum = array_pop($nums);
			foreach($nums as $key => $value){
				$runningTotal += $value * $multiplier;
				//echo $value . 'x' . $multiplier . ' + ';
				$multiplier --;
				if ($multiplier === 1){
					break;
				}
			}
			//echo ' = ' . $runningTotal;
			$remainder = $runningTotal % 11;
			$checksum = $remainder == 1 ? 'X' : 11 - $remainder;
			$checksum = $checksum == 11 ? 0 : $checksum;
			$output = array('checksum'=>$checksum);
			$output['isbn10'] = substr($input, 0, 9) . $checksum;
			if ($convert){
				$output['isbn13'] = isbn10to13($output['isbn10']);
			}
			if ((is_numeric($inputChecksum) || $inputChecksum == 'X') && $inputChecksum != $checksum){
				$output['error'] = 'Input checksum digit incorrect: ISBN not valid';
				$output['input_checksum'] = $inputChecksum;
			}
		}
		return $output;
	}

	function isbn10to13($isbn10){

		$isbnStem = strlen($isbn10) == 10 ? substr($isbn10, 0,9) : $isbn10;
		$isbn13data = isbn13checker('978' . $isbnStem);
		return $isbn13data['isbn13'];

	}

	function isbn13to10($isbn13){

		$isbnStem = strlen($isbn13) == 13 ? substr($isbn13, 12) : $isbn13;
		$isbnStem = substr($isbn13, -10);
		$isbn10data = isbn10checker($isbnStem);
		return $isbn10data['isbn10'];
	}
    


$array = $fields = array();
$i = 0;
if(file_exists("a.txt")){
    
    echo 'YES';
}
$handle = @fopen("a.txt", "r");
if ($handle):
    while (($row = fgetcsv($handle, 4096)) !== false):
        if (empty($fields)) {
            $fields = $row;
            continue;

       }

        foreach ($row as $k=>$value) {

            if($k==9){
                $value='0061655961';
               $all = isbn10to13($value);
               
               print('ISBN13------  '.$all);
            }
            

        $i++;
    }

endwhile;

endif;

?>