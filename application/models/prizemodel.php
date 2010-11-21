<?php

class PrizeModel extends Model{
	
	function addLotteryPrize() {
		$return = true;
		
		$query = "INSERT INTO lottery_prize (lottery_prize_id, lottery_id, dollar_amount, winner, prize)" .
				" values (NULL, \"". $this->input->post('lotteryId') ."\", " . $this->input->post('dollarAmount') . ", NULL, \"" . $this->input->post('prize') . "\" )";
		log_message('debug', 'PrizeModel.addLotteryPrize : Insert Lottery Prize : ' . $query);
		
		if ( $this->db->query($query) ) {
			$return = true;
		} else {
			$return = false;
		}
			
		return $return;
	}
	
	function getPrizesForLottery($id) {
		$query = "SELECT * FROM lottery_prize WHERE lottery_id = " . $id .
				" ORDER BY prize";
		
		log_message('debug', "PrizeModel.getPrizesForLottery : " . $query);
		$result = $this->db->query($query);
		
		$lotteryPrizes = array();
		
		foreach ($result->result_array() as $row) {
			
			$this->load->library('PrizeLib');
			unset($this->PrizeLib);
			
			$this->PrizeLib->lotteryPrizeId = $row['lottery_prize_id'];
			$this->PrizeLib->dollarAmount = $row['dollar_amount'];
			$this->PrizeLib->winner = $row['winner'];
			$this->PrizeLib->prize = $row['prize'];
			
			$lotteryPrizes[] = $this->PrizeLib;
			unset($this->PrizeLib);
		}
		return $lotteryPrizes;
	}
	
	function getPrizeFromId($prizeId) {
		
		$query = 'SELECT lottery_prize.*, lottery.lottery_name ' .
				' FROM lottery_prize, lottery ' .
				' WHERE lottery_prize.lottery_prize_id = ' . $prizeId . 
				' AND lottery_prize.lottery_id = lottery.lottery_id';
		
		log_message('debug', "PrizeModel.getPrizeFromId : " . $query);
		$result = $this->db->query($query);
		
		$this->load->library('PrizeLib');
		
		$row = $result->row();
		
		if ($row) {
			$this->PrizeLib->lotteryPrizeId = $row->lottery_prize_id;
			$this->PrizeLib->lotteryId = $row->lottery_id;
			$this->PrizeLib->lotteryName = $row->lottery_name;
			$this->PrizeLib->dollarAmount = $row->dollar_amount;
			$this->PrizeLib->prize = $row->prize;
			$this->PrizeLib->winner = $row->winner;
			
			return $this->PrizeLib;
		} else {
			return;
		}
	}
	
	function updateLotteryPrize() {
		$return = true;
		
		$data = array(
					//'lottery_id' => $this->input->post('lotteryId'),
					'dollar_amount' => $this->input->post('dollarAmount'), 
					'prize' => $this->input->post('prize')
				);
		$where = "lottery_prize_id = " . $this->input->post('lotteryPrizeId');
		$query = $this->db->update_string('lottery_prize', $data, $where);
		
		log_message('debug', 'PrizeModel.updateLotteryPrize : ' . $query);
		if ( $this->db->query($query) ) {
			$return = true;
		} else {
			$return = false;
		}
			
		return $return;
	}
	
}

?>