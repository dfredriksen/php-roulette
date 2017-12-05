<?php
$nums = [];
$colors = [];
$types = [];
$winnings = 0;//A Function to spin the roulette whe
$bet_amount = 50;
$bet = null;
$wins = 0;
$losses = 0;
$total_wins = 0;
$total_losses = 0;
$total_winnings = 0;
$total_trials = 0;
$average_winnings  = 0;
$average_losses = 0;
$average_wins = 0;
$black_losses = 0;
$red_losses = 0;
$zero_losses = 0;
$average_red_losses = 0;
$average_black_losses = 0;
$average_zero_losses = 0;
$largest_bet_amount = 0;
$largest_consecutive_loss = 0;
$largest_consecutive_win = 0;
$largest_consecutive_loss_tally = 0;
$largest_consecutive_win_tally = 0;
$win_amount = 0;
function spin(){
  
    $num=rand(1, 38);

    //they are putting bet on either red or black
    if($num==1 || $num==3 || $num==5 || $num==7 || $num==9 || $num==12 || $num==14 || $num==16 || $num==18 || $num==19 || $num==21 || $num==23 || $num==25 || $num==27 || $num==30 || $num==32 || $num==34 || $num==36){
      //red
      $winningcolor="red";
    }else if($num==37 || $num==38){
      //green
      $winningcolor="green";
    }else{
      //black
      $winningcolor="black";
    }

    return ['num'=>$num, 'color' => $winningcolor, 'type' => $num % 2 == 0 ? 'even' : 'odd'];

}

$hits = 0;
$bet = 'red';
$longest_left_swing = 0;
$longest_right_swing = 0;
$old_hit = 0;
$pivot_point = 0;
$old_trend = null;
$trend = null;
for($i = 0; $i < 10000; $i++)
{
    $number = spin();
    if($number['color'] != 'green')
    {
        $old_hit = $hits;        
        $hits += $number['color'] == $bet ? 1 : -1;        
    }

    if($hits > 0 && $hits > $longest_right_swing)
        $longest_right_swing = $hits;
    
    if($hits < 0 && $hits < $longest_left_swing)
        $longest_left_swing = $hits;        
}

echo 'Longest left swing: ' . $longest_left_swing . ', Longest right swing: ' . $longest_right_swing . ', Hits: ' . $hits . "\n";
 
