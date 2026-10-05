<?php
Kirby::plugin('mirthe/pinboard-import', [
    'options' => [
        'token' => option('pinboard.token'),
        'cron-token' => option('pinboard.cron-token')
    ],
    'routes' => [
        [
            'pattern' => 'pinboard/calendar',
            'action'  => function () {
                $kirby = kirby();
                if (($user = $kirby->user()) && $user->role()->id() === 'admin') {
                    $enddate = strtotime(date('Y-m-d'));
                    $startdate = strtotime('-6 months', $enddate);
                    $loopdate = $startdate;

                    $mijnoutput = '<p>Get links for the week ending on:</p>';

                    while ($loopdate <= $enddate) {
                        $loopdate = strtotime('+1 day', $loopdate);
                        $einddatum = date('Y-m-d', $loopdate);
                        $showdate = date('Y-m-d', strtotime('-1 day', $loopdate));

                        $day = date('w', $loopdate);
                        if ($day == 1) {
                            $mijnoutput .= '<a href="import?einddatum='.$einddatum.'">' . $showdate . '</a><br>';
                        }
                    }

                    return $mijnoutput;
                }
            }
        ],
        [
            'pattern' => 'pinboard/import',
            'action'  => function () {
                $kirby = kirby();
                $user = $kirby->user();
                $isAdmin = $user && $user->role()->id() === 'admin';
                $cronToken = option('mirthe.pinboard-import.cron-token');
                $providedToken = $_SERVER['HTTP_X_CRON_TOKEN'] ?? '';
                $isCron = is_string($cronToken)
                    && $cronToken !== ''
                    && is_string($providedToken)
                    && hash_equals($cronToken, $providedToken);

                if ($isAdmin || $isCron) {
                    if (isset($_GET["einddatum"])) {
                        $einddatum = htmlspecialchars($_GET["einddatum"]);
                    } else {
                        $einddatum = date('Y-m-d');
                    }

                    if (date('w', strtotime($einddatum)) == 1) {
                        include 'connect.php';

                        if ($HTTPCode == 200) {
                            include 'import.php';
                            return 'File written: ' . $folder . ' at ' . date('Y-m-d H:i:s') . '<br />';
                        }

                        return $HTTPCode;
                    }

                    return 'Alleen voor maandagen uitvoeren..';
                }
            }
        ]
    ]
]);
