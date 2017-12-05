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

$bank = 0;
$hand = 0;
$savings = 0;
$losing_bet = 50;
$minimum_bet = 100;
$maximum_bet = 100;
$max_plays = 13;
$max_weeks = 4;
$max_days = 3;
$max_months = 1;
$bet_increase = 25;
$bet_decrease = 25;
$choice = 'red';
$opposite = 'black';
$chase_mode = false;
$correct_guess = 0;
$max_daily_risk = 1000;
$daily_risk = 1000;
$table_minimum = 25;

    for($a = 0; $a <  $max_months; $a++)
    {
        //print_r('********************Month ' . $a . "******************************\n");  

        for($b = 0; $b < $max_weeks; $b++)
        {
            $daily_risk = $max_daily_risk;

            $minimum_bet= $maximum_bet;

            //echo '========Week ' . $b . "========\n";
            if($hand < $daily_risk)
            {
                //echo 'Withdrew ' . ($daily_risk - $hand) . ' from bank.' . "\n";
                $bank -= ($daily_risk - $hand);       
                if($bank < 0)
                {
                    $savings += abs($bank);
                    $bank = 0;
                }
                $hand += ($daily_risk - $hand);
            }

            //echo 'Money in bank $' . number_format($bank, 2). "\n";
            
            for($i = 0; $i < $max_days; $i++)
            {
                $play = 0;
                $sequence = 0;

                //echo "Day " . $i . "\n"; 

                if($hand == 0)
                {
                    //echo "Broke, done for the week...\n";
                    break;
                }

                $total_banked = 0;

                $win_count = 0;

                $bet = null;
                $chase_mode = false;
                $guess = 0;
                for( $play = 0; $play < $max_plays; $play++) {
                    $number = spin();
                    $nums[] = $number['num'];
                    $colors[] = $number['color'];
                    $types[] = $number['type'];
                    $bet = "red";

                    if($hand < $table_minimum)
                    {
                        //echo 'Do not have enough to play.' . "\n";
                        break;
                    }

                    if($guess > -5)
                        $bet_amount = 0;
                    else
                        $bet_amount = ceil(($hand)/10) * 10;

                    if($bet_amount >0)
                        //echo 'Betting $' . number_format($bet_amount, 2) . "\n";

                    if($bet_amount > $hand)
                        $bet_amount = $hand;

                        if($bet == 'red' || $bet == 'black' || $bet == 'green')
                        {
                            $hand -= $bet_amount;

                            //print_r($number['color']);
                            //echo "\n";
                            if($bet != $number['color'])
                            {
                                if($number['color'] == 'black' && $bet_amount > 0)
                                {
                                    $black_losses++;            
                                }
                                else if($number['color'] == 'red' && $bet_amount > 0)
                                {
                                    $red_losses++;
                                }
                                else if ($bet_amount > 0)
                                    $zero_losses++;
                             
                                $guess--;

                                //if(!$chase_mode)
                                //{
                                //    echo 'entering chase mode.' ."\n";
                                //    $chase_mode = true;                    
                                //}
                                //print_r($bet_amount . " LOST!\n"); 

                                //$bet_amount *= 2;
                                //echo "LOST!";
                                if($bet_amount > 0)
                                {
                                    //echo 'Defeat! Lost $'  . number_format($bet_amount,2) . '. Escape...' . "\n";                            
                                    $losses++; 
                                    break;         
                                }

                            }
                            else
                            {
                                if($bet == 'green')
                                {
                                    $win_amount = $bet_amount * 8;
                                    //echo 'GREEN hit!';
                                }
                                else
                                    $win_amount = $bet_amount * 2;

                                $bet = null;                       
                                $hand += $win_amount;
                                $chase_mode = false;

                                $guess++;

                                if($win_amount > 0)
                                {
                                    $total_winnings += $winnings;
                                    $winnings += $win_amount;     

                                    $bank += $hand;
                                    $hand = 0;
                                    //echo 'Victory! Win $'. number_format($bet_amount,2) . ' Get out now.' . "\n";
                                    $wins++;               
                                    break;
                                }

                            }              
                        }

                        $nums = [];
                        $colors = [];
                        $types = [];

    //                }
    //                else
    //                    $sequence++;            
                    $total_wins += $wins;
                    $total_losses += $losses;
                    $total_trials++;          

                }

                //echo 'Hand: $' . number_format($hand,2) .  "\n";

            }

            if($hand > 0)
            {
                $bank += $hand;
                //echo 'Banked $' . number_format($hand, 2) . " after 1 week.\n";
                //echo 'Money in bank: $' . number_format($bank, 2) . "\n";
                $hand = 0;
            }

        }
    }

    $average_winnings = $total_winnings / $total_trials;
    $average_losses = $total_losses / $total_trials;
    $average_wins = $total_wins / $total_trials;
    $average_red_losses = $red_losses / $total_trials;
    $average_black_losses = $black_losses / $total_trials;
    $average_zero_losses = $zero_losses / $total_trials;

    echo 'You won an average of $'. number_format($average_winnings,2) . '. You won an average of ' . $average_wins . ' times and lost an average of ' . $average_losses . ' times' ."\n" ;
    echo 'Red losses avg: ' . $average_red_losses .  ' Black losses avg: ' . $average_black_losses .  ' zero losses average ' . $average_zero_losses . "\n";
    echo 'You banked $' . number_format($bank, 2) . "\n";
    echo 'You would have saved $' . number_format($savings,2) . "\n";

    if($savings - $bank > 0)
        echo 'Your net loss is $' . number_format($savings-$bank, 2);
    else
        echo 'Your net gain is $' . number_format($bank-$savings, 2);


