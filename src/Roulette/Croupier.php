<?php
namespace DFredriksen\Roulette;

class RouletteWheel
{
    public $nums;
    public $colors;
    public $types;
    public $winnings;
    public $bet_amount;
    public $bet;
    public $wins;
    public $losses;
    public $total_wins;
    public $total_losses;
    public $total_winnings;
    public $total_trials;
    public $average_winnings ;
    public $average_losses;
    public $average_wins;
    public $black_losses;
    public $red_losses;
    public $zero_losses;
    public $average_red_losses;
    public $average_black_losses;
    public $average_zero_losses;
    public $largest_bet_amount;
    public $largest_consecutive_loss;
    public $largest_consecutive_win;
    public $largest_consecutive_loss_tally;
    public $largest_consecutive_win_tally;
    public $win_amount;
    public $single_count;

    public function __construct()
    {

        $this->nums = [];
        $this->colors = [];
        $this->types = [];
        $this->winnings = 0;//A Function to spin the roulette whe
        $this->bet_amount = 50;
        $this->bet = null;
        $this->wins = 0;
        $this->losses = 0;
        $this->total_wins = 0;
        $this->total_losses = 0;
        $this->total_winnings = 0;
        $this->total_trials = 0;
        $this->average_winnings  = 0;
        $this->average_losses = 0;
        $this->average_wins = 0;
        $this->black_losses = 0;
        $this->red_losses = 0;
        $this->zero_losses = 0;
        $this->average_red_losses = 0;
        $this->average_black_losses = 0;
        $this->average_zero_losses = 0;
        $this->largest_bet_amount = 0;
        $this->largest_consecutive_loss = 0;
        $this->largest_consecutive_win = 0;
        $this->largest_consecutive_loss_tally = 0;
        $this->largest_consecutive_win_tally = 0;
        $this->win_amount = 0;
        $this->single_count = 0;
    }


    public function calculateStatistics()
    {

        $frequencies = [];
        $means = [];
        $target_percentile = [];
        $variances = [];
        $stds = [];
        $trialcount = 1000;
        $playcount = 20;

        for($a = 0; $a < $trialcount; $a++)
        {
            $streak = 0;
            $color = null;    
            $last_pick = null;
            $frequencies[$a] = [];
            
            for($i = 0; $i < $playcount; $i++)
            {
                $pick = spin()['color'];

                if($last_pick == null || $pick != $last_pick)
                {
                    if($last_pick != null)
                    {
                        if(empty($frequencies[$a][$streak]))
                            $frequencies[$a][$streak] = 0;

                        $frequencies[$a][$streak]++;
                        if($streak == 1)
                            $single_count++; 
                    }
                    $streak = 0;
                }
                else
                    $streak++;

                $last_pick = $pick;

            }
        }

        foreach($frequencies as $trial)
        {
            foreach($trial as $streak=>$frequency)
            {
                if(empty($means[$streak]))
                    $means[$streak] = 0;

                $means[$streak]+=$frequency;
            }
        }

        foreach($means as $streak=>$tota)
        {
            $means[$streak] /= $trialcount;    
        }

        foreach($frequencies as $trial)
        {
            foreach($trial as $streak=>$frequency)
            {
                if(empty($variances[$streak]))
                    $variances[$streak] = 0;

                $variances[$streak] += ($frequency - $means[$streak]);
            }
        }

        foreach($variances as $streak=>$total)
        {
            $variances[$streak] /= $trialcount;
            $stds[$streak] = sqrt($variances[$streak]);
        }

        foreach($means as $streak=>$total)
        {
            $target_percentile[$streak] = ceil($means[$streak] + ($stds[$streak]*2));
        }


        ksort($means);
        ksort($variances);
        ksort($stds);
        ksort($target_percentile);
        echo "Means\n";
        print_r($means);

        echo "Variances\n";
        print_r($variances);

        echo "STDs\n";
        print_r($stds);

        echo "Target percentile\n";
        print_r($target_percentile);
    }
}

