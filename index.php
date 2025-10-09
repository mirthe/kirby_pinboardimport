<?php
$kirby = kirby();
if (($user = $kirby->user()) && $user->role()->id() === 'admin') {

    Kirby::plugin('mirthe/pinboard-import', [
        'options' => [
            'token' => option('pinboard.token')
        ],
        'routes' => [
            [
            'pattern' => 'pinboard/calendar',
            'action'  => function () {

                $enddate = strtotime(date('Y-m-d'));
                $startdate = strtotime('-6 months', $enddate);
                $loopdate = $startdate;
                
                $mijnoutput = '<p>Get links for the week ending on:</p>';

                while ($loopdate <= $enddate) {
                    $loopdate = strtotime('+1 day', $loopdate);
                    $einddatum = date("Y-m-d", $loopdate);
                    $showdate = date("Y-m-d", strtotime('-1 day', $loopdate));
                
                    $day = date('w', $loopdate);
                    if ($day == 1) { // alleen op maandag uitvoeren voor de voorgaande week..
                        $mijnoutput .= '<a href="import?einddatum='.$einddatum.'">'. $showdate . "</a><br>";
                    }
                }

                return $mijnoutput;
            }
            ],
            [
                'pattern' => 'pinboard/import',
                'action'  => function () {

                    if (isset($_GET["einddatum"])) {
                        $einddatum = htmlspecialchars($_GET["einddatum"]);
                    } else {
                        // NOTE uitvoeren op maandagochtend, dus ophalen tot vandaag (tot en met gister = zondag)
                        $einddatum = date('Y-m-d');
                    }

                    if (date("w", strtotime($einddatum)) == 1) {
                        include 'connect.php';
                        
                        // if we got a 200 code, the request was successful. otherwise, it wasn't
                        if ($HTTPCode == 200) {
                            include 'import.php';
                            return 'File written: ' . $folder . ' at ' . date('Y-m-d H:i:s') . '<br />';
                        } else {
                            return $HTTPCode;
                        }
                    } else {
                        return "Alleen voor maandagen uitvoeren..";
                    }
                }
            ]
        ]
    ]);

;}
