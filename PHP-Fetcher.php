<?php 
	printf("\nShadowverse Image Artwork Fetcher V.1.0\n\nFetching data from Bagoum API...\n");
	$bagoum_fetch_start = new Datetime();

	$bagoum_url = 'http://sv.bagoum.com/cardsFullJSON' ;
	$card_data = file_get_contents($bagoum_url);
	$card_array = json_decode($card_data, true);
	$card_list = array_values($card_array);

	$bagoum_fetch_finish = new Datetime();
	$fetch_interval = date_diff($bagoum_fetch_start, $bagoum_fetch_finish);
	$fetch_completion = $fetch_interval->format("%i minutes %s seconds");

	printf("\nData Retrieved from Bagoum in %s\n\nStarting image download...\n\n", $fetch_completion);

	$number_of_card = count($card_list);
	$counter = 0 ;
	if (!is_dir("./Bordered")) {
		mkdir("./Bordered");
	}
	$file_path = "./Bordered/" ;

	$start_process_timestamp = new Datetime();

	for ($counter=0; $counter < $number_of_card ; $counter++) { 
		$new_batch_timestamp = new Datetime();

		// Fetch Normal Art
		$saved_name = $card_list[$counter]['name'] . "_n_1.png" ;
		$card_id = $card_list[$counter]['id'];
		$fetched_image = file_get_contents("https://shadowverse-portal.com/image/card/en/C_$card_id.png");
		if (strlen($fetched_image) > 10000) {
			file_put_contents($file_path . $saved_name, $fetched_image);
		}

		// Fetch Alt Image
		if ($card_list[$counter]['hasAlt'] == TRUE) {
			$saved_name = $card_list[$counter]['name'] . "_alt_1.png" ;
			$card_id = $card_list[$counter]['altid'];
			$fetched_image = file_get_contents("https://shadowverse-portal.com/image/card/en/C_$card_id.png");
			if (strlen($fetched_image) > 10000) {
				file_put_contents($file_path . $saved_name, $fetched_image);
			}
		}

		// Fetch Alt Image Version 2
		if ($card_list[$counter]['hasAlt2'] == TRUE) {
			$saved_name = $card_list[$counter]['name'] . "_alt2_1.png" ;
			$card_id = $card_list[$counter]['altid2'];
			$fetched_image = file_get_contents("https://shadowverse-portal.com/image/card/en/C_$card_id.png");
			if (strlen($fetched_image) > 10000) {
				file_put_contents($file_path . $saved_name, $fetched_image);
			}
		}

		// Fetch Evolved Image
		if ($card_list[$counter]['hasEvo'] == TRUE) {
			$saved_name = $card_list[$counter]['name'] . "_n_2.png" ;
			$card_id = $card_list[$counter]['id'];
			$fetched_image = file_get_contents("https://shadowverse-portal.com/image/card/en/E_$card_id.png");
			if (strlen($fetched_image) > 10000) {
				file_put_contents($file_path . $saved_name, $fetched_image);
			}

			// Fetch Evolved Alt Image 
			if ($card_list[$counter]['hasAlt'] == TRUE) {
				$saved_name = $card_list[$counter]['name'] . "_alt_2.png" ;
				$card_id = $card_list[$counter]['altid'];
				$fetched_image = file_get_contents("https://shadowverse-portal.com/image/card/en/E_$card_id.png");
				if (strlen($fetched_image) > 10000) {
					file_put_contents($file_path . $saved_name, $fetched_image);
				}
			}

			// Fetch Evolved Alt Image Version 2
			if ($card_list[$counter]['hasAlt2'] == TRUE) {
				$saved_name = $card_list[$counter]['name'] . "_alt2_2.png" ;
				$card_id = $card_list[$counter]['altid2'];
				$fetched_image = file_get_contents("https://shadowverse-portal.com/image/card/en/E_$card_id.png");
				if (strlen($fetched_image) > 10000) {
					file_put_contents($file_path . $saved_name, $fetched_image);
				}
			}
		}

		$end_batch_timestamp = new Datetime();

		$interval = date_diff($new_batch_timestamp, $end_batch_timestamp);
		$completion_times = $interval->format("%i m %s s");

		printf("Saved Image of %s (%s of %s) - %s\n", $card_list[$counter]['name'], $counter + 1, $number_of_card, $completion_times);
	}

	$end_process_timestamp = new Datetime();

	$process_interval = date_diff($start_process_timestamp, $end_process_timestamp);
	$process_completion = $process_interval->format("%h hours %i minutes %s seconds");
	printf("\nProcess Completed in %s", $process_completion);
?>