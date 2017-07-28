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

$five = [];
$total_hits = 0;
$longest_run = 0;
$total_run = 0;
for($x = 0; $x < 1000; $x++)
{
    $hits = 0;
    $run  = 0;
    $longest_run = 0;
    for($i = 0; $i < 100; $i++)
    {
        $number = spin();
        $five[] = $number;
        if($i > 3)
        {

            if($number['color'] == 'black')
                $run++;

            if($run > $longest_run)
                $longest_run = $run;

            if($five[0] == $five[1] && $five[1] == $five[2] && $five[2] == $five[3] && $five[3] == $five[4] && $five[0] == 'black')
            {
                $hits++;
                echo 'black' . "\n";
            }
            else
            {
                $run = 0;
                echo $number['color'] . "\n";
            }
            array_shift($five);        
        }
    }

    $total_run += $longest_run;
    $total_hits += $hits;
}


echo 'Average hits ' . $total_hits/1000 . '/100' ."\n";
echo 'Average longest run of black ' . $longest_run/1000 . "\n";
