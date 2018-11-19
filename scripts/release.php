<?php

chdir(dirname(__DIR__));

$options = getopt('hnDd', [
    'dry-run',
    'dryrun',
    'dev',
    'help',
]);

$name = basename(__FILE__, '.php');
$help = isset($options['h']) || isset($options['help']) || isset($options['version']);
$release = !isset($options['dev']) && !isset($options['d']);
$dry = isset($options['n']) || isset($options['dry-run']) || isset($options['dryrun']);

if ($help) {
    echo <<<EOT
Update version numbers and dates.

Usage:
  $ $name [options]

Options:

  -h, --help     Print this message
  -n, --dry-run  Dry-run without writing
  -d, --dev      Development release
EOT;

    return;
}

$url = 'https://github.com/textile/php-textile/releases/tag/v';
$date = strftime('%Y/%m/%d');
$version = '0.0.0';
$minor = '0.0';
$install = '0.0.*';
$dev = '0.0-dev';

if (preg_match('/h2. Version (\d+\.[^\s]+) - upcoming/', file_get_contents('CHANGELOG.textile'), $m)) {
    $version = $m[1];
} else {
    echo "No upcoming version number in CHANGELOG.textile\n";
    exit(1);
}

if (preg_match('/^(\d+\.\d+)/', $version, $m)) {
    $minor = $m[1];
}

$install = $minor . '.*';
$dev = $minor . '-dev';

if (!$release) {
    $version = $version . '-dev';
}

echo <<<EOT
Version: $version
  Minor: $minor
Install: $install
    Dev: $dev
   Date: $date

EOT;

$update = [
    'src/Netcarver/Textile/Parser.php' => [
        '/(protected \$ver = \')([^\']+)(\';)/' => function ($m) use ($version) {
            return $m[1] . $version . $m[3];
        },
    ],
    'composer.json' => [
        '/("dev-master": ")([^"])(")/' => function ($m) use ($minor) {
            return $m[1] . $dev . $m[2];
        }
    ]
];

if ($release) {
    $update['README.textile'] = [
        '/(\/textile[ :])(\d+\.\d+\.\*)/' => function ($m) use ($install) {
            return $m[1] . $install;
        }
    ];

    $update['CHANGELOG.textile'] = [
        '/(h2. )([\s\S]+)(upcoming)/' => function ($m) use ($date, $url, $version) {
            return $m[1] . '"' . $m[2] . $date . '":' . $url . $version;
        }
    ];
}

foreach ($update as $file => $replacements) {
    echo "· $file\n";

    $content = file_get_contents($file);

    foreach ($replacements as $from => $to) {
        $content = preg_replace_callback($from, $to, (string) $content);
    }

    if ($dry) {
        continue;
    }

    if (file_put_contents($file, $content) === false) {
        exit(1);
    }
}
