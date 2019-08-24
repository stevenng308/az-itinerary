<?php
class ItinerarySplit 
{
  public function azReport()
        {
            $peoplePaid = [
                'steven' => [
                    'airportparking',
                    'car1',
                    'car2',
                    'phoenix',
                    'gchotel',
                    'page',
                    'pizza',
                    'gas1',
                    'safe3',
                    'wally4',
                    'antelopetip'
                ],
                'haris' => [
                    'gccamp',
                    'antelope',
                    'wally2',
                    'wood',
                    'horseshoe'
                ],
                'michelle' => [
                    'sedona',
                    'safe1',
                    'safe2',
                    'wally3',
                    'gas2',
                    'gas3',
                    'gas4'
                ],
                'xiwen' => [
                    'wally1'
                ]
            ];

            $activityExclude = [
                'airportparking' => [
                    'michelle',
                    'tj',
                ],
                'car1' => [
                    'michelle',
                    'tj',
                ],
                'phoenix' => [
                    'michelle',
                    'tj',
                ],
                'gchotel' => [
                    'michelle',
                    'tj',
                    'haris'
                ],
                'gccamp' => [
                    'steven',
                    'linda',
                    'xiwen'
                ],
                'sedona' => [
                    'haris'
                ]
            ];

            $transactions = [
                'airportparking' => 39,
                'car1' => 65.13,
                'car2' => 261.32,
                'phoenix' => 82.32,
                'gchotel' => 206.27,
                'page' => 397.95,
                'pizza' => 69.2,
                'gas1' => 35.75,
                'safe3' => 15.68,
                'wally4' => 12.06,
                'antelopetip' => 20,
                'gccamp' => 18,
                'antelope' => 408,
                'wally2' => 18.86,
                'wood' => 8.11,
                'horseshoe' => 10,
                'sedona' => 105.41,
                'safe1' => 41.16,
                'safe2' => 6.46,
                'wally3' => 2.4,
                'gas2' => 39.29,
                'gas3' => 29.7,
                'gas4' => 29.06,
                'wally1' => 37.26
            ];

            $whoPaysWho = [
                'steven' => [
                    'haris' => 0,
                    'michelle' => 0,
                    'xiwen' => 0
                ],
                'haris' => [
                    'steven' => 0,
                    'michelle' => 0,
                    'xiwen' => 0
                ],
                'michelle' => [
                    'haris' => 0,
                    'steven' => 0,
                    'xiwen' => 0
                ],
                'xiwen' => [
                    'haris' => 0,
                    'michelle' => 0,
                    'steven' => 0
                ],
                'linda' => [
                    'xiwen' => 0,
                    'haris' => 0,
                    'michelle' => 0,
                    'steven' => 0
                ],
                'tj' => [
                    'xiwen' => 0,
                    'haris' => 0,
                    'michelle' => 0,
                    'steven' => 0
                ],
            ];

            $participants = array_keys($whoPaysWho);
            foreach($peoplePaid as $payee => $activity)
            {
                foreach($activity as $act)
                {
                    $participantClone = $participants;
                    foreach($participantClone as $key => $person)
                    {
                        if(isset($activityExclude[$act]) && in_array($person, $activityExclude[$act]) || $payee === $person)
                        {
                            unset($participantClone[$key]);
                        }
                    } //trim list of people that will pay for the respective activity
                    $split = round(($transactions[$act] / (count($participantClone) + 1)), 2);
                    foreach($participantClone as $payer)
                    {
                        $whoPaysWho[$payer][$payee] += $split;
                    }
                }
            }
            var_dump($whoPaysWho); // gross pay
            foreach($peoplePaid as $receiver => $activity)
            {
                $pendingTransaction = $whoPaysWho[$receiver];
                foreach($whoPaysWho as $payer => $payees)
                {
                    if($payer !== $receiver && !empty($pendingTransaction[$payer]))
                    {
                        $payerAmount = $pendingTransaction[$payer];
                        $payeeAmount = $payees[$receiver];
                        if($payerAmount !== 0 && $payeeAmount !== 0 && $payerAmount < $payeeAmount)
                        {
                            $payeeAmount -= $payerAmount;
                            $whoPaysWho[$receiver][$payer] = 0;
                            $whoPaysWho[$payer][$receiver] = $payeeAmount;
                        }
                    }
                }
            }
            var_dump($whoPaysWho); //net pay
        }
    }
?>
