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
$minimum_bet = 1000;
$maximum_bet = 1000;
$max_plays = 100;
$max_weeks = 4;
$max_days = 7;
$max_months = 12;
$bet_increase = 25;
$bet_decrease = 25;
$choice = 'red';
$opposite = 'black';
$chase_mode = false;
$correct_guess = 0;
$max_daily_risk = 2000;
$daily_risk = 2000;
$table_minimum = 25;
for($a = 0; $a <  $max_months; $a++)
{
    print_r('********************Month ' . $a . "******************************\n");  

    for($b = 0; $b < $max_weeks; $b++)
    {
        $daily_risk = $max_daily_risk;

        $minimum_bet= $maximum_bet;

        echo '========Week ' . $b . "========\n";
        if($hand < $daily_risk)
        {
            echo 'Withdrew ' . ($daily_risk - $hand) . ' from bank.' . "\n";
            $bank -= ($daily_risk - $hand);       
            if($bank < 0)
            {
                $savings += abs($bank);
                $bank = 0;
            }
            $hand += ($daily_risk - $hand);
        }
        
        for($i = 0; $i < $max_days; $i++)
        {
            $play = 0;
            $sequence = 0;

            echo "Day " . $i . "\n"; 

            if($hand == 0)
            {
                echo "Broke...\n";
                break;
            }

            $total_banked = 0;

            $win_count = 0;

            $bet = null;
            $chase_mode = false;
            for( $play = 0; $play < $max_plays; $play++) {
                $number = spin();
                $nums[] = $number['num'];
                $colors[] = $number['color'];
                $types[] = $number['type'];
                $bet = "red";
                $bank_threshold = (($daily_risk) + ($daily_risk/2));
                $bank_amount = (($daily_risk) + (($daily_risk/2)/2));
                if($hand >= $bank_threshold)
                {
                    $bank += $bank_amount;
                    echo 'Banked: $' . $bank_amount . "\n";               
                    $total_banked += $bank_amount;
                    $hand -= $bank_amount;       
                    $minimum_bet = $table_minimum;
                } 
                elseif( $hand < $daily_risk)
                {
                    $minimum_bet = $table_minimum;
                    echo 'Dropping bet to ' . $table_minimum . "\n";
                }
                elseif( $hand == 0)
                {
                    echo 'No more money, quit!' . "\n";
                    break;
                }

                $bet_amount = $minimum_bet;        

                if($table_minimum >  $hand)
                {
                    echo 'Not enough for the table minimum' . "\n";
                    break;
                }

                //$hand -= $bet_amount;
                //$winnings -= $bet_amount;


//                if($sequence == 2 && !$chase_mode)
//                {              
//                    if($colors[0] == $colors[1] && $colors[1] == $colors[2] && $colors[0] == $opposite)
//                    {
//                        $bet = $choice;
                        //print_r($colors);                //echo "Bet $bet \n";
//                    }
                    //else if($types[0] == $types[1] && $types[1] == $types[2])
                    //{
                    //    $bet = $types[0] == 'even' ? 'odd' : 'even';
                        //print_r($types);
                        //echo "Bet $bet \n";
                    //}

//                    $sequence++;
//                }
//                else if($sequence == 3 || $chase_mode)
//                {
//                    $sequence = 0;
                    if($bet == 'red' || $bet == 'black' || $bet == 'green')
                    {
                        $hand -= $bet_amount;

                        echo 'Bet: ' . $bet_amount .', ';

                        //print_r($number['color']);
                        //echo "\n";
                        if($bet != $number['color'])
                        {
                            if($number['color'] == 'black')
                            {
                                $black_losses++;            
                            }
                            else if($number['color'] == 'red')
                            {
                                $red_losses++;
                            }
                            else
                                $zero_losses++;
                         
                            echo ' lost!' . "\n";
                            echo 'Hand: $' . number_format($hand) . "\n";

                            //if(!$chase_mode)
                            //{
                            //    echo 'entering chase mode.' ."\n";
                            //    $chase_mode = true;                    
                            //}
                            //print_r($bet_amount . " LOST!\n"); 

                            //$bet_amount *= 2;
                            //echo "LOST!";
                            $losses++;          

                            if($bet_amount > ($hand))
                            {
                                $bet_amount = $minimum_bet;
                                $chase_mode = false;               
                                $bet = null;     
                                echo "Bet too high. Backing down."; 
                            }
                        }
                        else
                        {
                            if($bet == 'green')
                            {
                                $win_amount = $bet_amount * 8;
                                echo 'GREEN hit!';
                            }
                            else
                                $win_amount = $bet_amount * 2;

                            echo ' won!' . "\n";
                            $bet = null;                       
                            $hand += $win_amount;
                            $winnings += $win_amount;     
                            $chase_mode = false;
                            $bet_amount = $minimum_bet / 2;

                            if($minimum_bet < $table_minimum)
                                $minmum_bet = $table_minimum;

                            echo 'Hand: ' . number_format($hand,2) . "\n";

                            $wins++;               
                        }              
                    }

                    $nums = [];
                    $colors = [];
                    $types = [];

//                }
//                else
//                    $sequence++;             
            }

            $daily_risk = $daily_risk / 2;

            $total_winnings += $winnings;
            $total_wins += $wins;
            $total_losses += $losses;
            $total_trials++;       
        }

        if($hand > 0)
        {
            $bank += $hand;
            echo 'Banked $' . number_format($hand, 2) . " after $max_plays plays.\n";
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

echo 'You won an average of $'. $average_winnings . '. You won an average of ' . $average_wins . ' times and lost an average of ' . $average_losses . ' times' ."\n" ;
echo 'Red losses avg: ' . $average_red_losses .  ' Black losses avg: ' . $average_black_losses .  ' zero losses average ' . $average_zero_losses . "\n";
echo 'You banked $' . number_format($bank, 2) . "\n";
echo 'You would have saved $' . number_format($savings,2) . "\n";

if($savings - $bank > 0)
    echo 'Your net loss is $' . number_format($savings-$bank, 2);
else
    echo 'Your net gain is $' . number_format($bank-$savings, 2);
