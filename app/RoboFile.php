<?php

use Robo\Tasks;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * RoboFile is the task runner for this project
 *
 * @copyright Copyright (c) 2015, John Nickell. <http://johnnickell.com>
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @author    John Nickell <email@johnnickell.com>
 */
class RoboFile extends Tasks
{
    /**
     * Application paths
     *
     * Access with getPaths()
     *
     * @var array
     */
    private $paths;

    /**
     * Filesystem
     *
     * Access with getFilesystem()
     *
     * @var Filesystem
     */
    private $filesystem;

    //===================================================//
    // Main Targets                                      //
    //===================================================//

    /**
     * The default build process
     */
    public function build()
    {
        $this->dirPrepare();
        $this->bowerInstall();
        $this->bowerUpdate();
        $this->bowerPrune();
        $this->assetsCompileSass();
        $this->assetsRequireJs();
        $this->phpLint();
        $this->phpCodeStyle();
        $this->phpMessDetect();
        $this->phpTestUnit();
        $this->yell('build complete');
    }

    //===================================================//
    // Asset Targets                                     //
    //===================================================//

    /**
     * Compiles Sass assets
     *
     * @param array $opts The options
     *
     * @option $prod Optimize for production
     */
    public function assetsCompileSass($opts = ['prod' => false])
    {
        $prod = isset($opts['prod']) && $opts['prod'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('assets:compile-sass');
        $this->info('Compiling Sass assets');

        $exec = $this->taskExec('compass')
            ->dir($paths['assets'])
            ->arg('compile');
        if ($prod) {
            $exec->option('output-style', 'compressed');
        } else {
            $exec->option('output-style', 'expanded');
        }
        $exec
            ->printed(true)
            ->run();

        $this->info('Sass assets compiled');
    }

    /**
     * Optimizes RequireJS modules for production
     */
    public function assetsRequireJs()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('assets:require-js');
        $this->info('Optimizing RequireJS modules');
        $iterator = Finder::create()
            ->files()
            ->name('rbuild_*.js')
            ->in($paths['build']);
        foreach ($iterator as $file) {
            $this->taskExec('node')
                ->arg($paths['build'].'/r.js')
                ->arg('-o')
                ->arg($file->getRealPath())
                ->printed(true)
                ->run();
        }
        $this->info('RequireJS modules optimized');
    }

    //===================================================//
    // Bower Targets                                     //
    //===================================================//

    /**
     * Installs bower dependencies
     *
     * @param array $opts The options
     *
     * @option $prod Optimize for production
     */
    public function bowerInstall($opts = ['prod' => false])
    {
        $prod = isset($opts['prod']) && $opts['prod'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('bower:install');
        $this->info('Installing assets with bower');
        $exec = $this->taskExec('bower')
            ->dir($paths['root'])
            ->arg('install')
            ->option('config.interactive=false');
        if ($prod) {
            $exec->option('production');
        }
        $exec->printed(true)
            ->run();
        $this->info('Bower install complete');
    }

    /**
     * Prunes bower dependencies
     */
    public function bowerPrune()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('bower:prune');
        $this->info('Pruning assets with bower');
        $exec = $this->taskExec('bower')
            ->dir($paths['root'])
            ->arg('prune')
            ->option('config.interactive=false')
            ->printed(true)
            ->run();
        $this->info('Bower prune complete');
    }

    /**
     * Updates bower dependencies
     *
     * @param array $opts The options
     *
     * @option $prod Optimize for production
     */
    public function bowerUpdate($opts = ['prod' => false])
    {
        $prod = isset($opts['prod']) && $opts['prod'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('bower:update');
        $this->info('Updating assets with bower');
        $exec = $this->taskExec('bower')
            ->dir($paths['root'])
            ->arg('update')
            ->option('config.interactive=false');
        if ($prod) {
            $exec->option('production');
        }
        $exec->printed(true)
            ->run();
        $this->info('Bower update complete');
    }

    //===================================================//
    // Composer Targets                                  //
    //===================================================//

    /**
     * Installs Composer dependencies
     *
     * @param array $opts The options
     *
     * @option $prod Optimize for production
     */
    public function composerInstall($opts = ['prod' => false])
    {
        $prod = isset($opts['prod']) && $opts['prod'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('composer:install');
        $this->info('Installing Composer dependencies');
        $exec = $this->taskExec('composer')
            ->dir($paths['root'])
            ->arg('install')
            ->option('prefer-dist');
        if ($prod) {
            $exec->option('no-dev');
            $exec->option('optimize-autoloader');
        }
        $exec->printed(true)
            ->run();
        $this->info('Composer dependencies installed');
    }

    /**
     * Updates Composer dependencies
     *
     * @param array $opts The options
     *
     * @option $prod Optimize for production
     */
    public function composerUpdate($opts = ['prod' => false])
    {
        $prod = isset($opts['prod']) && $opts['prod'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('composer:update');
        $this->info('Updating Composer dependencies');
        $exec = $this->taskExec('composer')
            ->dir($paths['root'])
            ->arg('update')
            ->option('prefer-dist');
        if ($prod) {
            $exec->option('no-dev');
            $exec->option('optimize-autoloader');
        }
        $exec->printed(true)
            ->run();
        $this->info('Composer dependencies updated');
    }

    /**
     * Updates composer.lock file hash
     */
    public function composerUpdateHash()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('composer:update-hash');
        $this->info('Updating Composer lock file');
        $exec = $this->taskExec('composer')
            ->dir($paths['root'])
            ->arg('update')
            ->option('lock')
            ->printed(true)
            ->run();
        $this->info('Composer lock file updated');
    }

    //===================================================//
    // Directory Targets                                 //
    //===================================================//

    /**
     * Cleans artifact directories
     */
    public function dirClean()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('dir:clean');
        $this->info('Cleaning artifact directories');
        $this->taskFileSystemStack()
            ->remove($paths['coverage'])
            ->remove($paths['reports'])
            ->remove($paths['docapi'])
            ->run();
        $this->info('Artifact directories cleaned');
    }

    /**
     * Prepares artifact directories
     */
    public function dirPrepare()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->dirClean();
        $this->yell('dir:prepare');
        $this->info('Preparing artifact directories');
        $this->taskFileSystemStack()
            ->mkdir($paths['coverage'])
            ->mkdir($paths['reports'])
            ->mkdir($paths['docapi'])
            ->run();
        $this->info('Artifact directories prepared');
    }

    //===================================================//
    // PHP Targets                                       //
    //===================================================//

    /**
     * Performs code style check on PHP source
     *
     * @param array $opts The options
     *
     * @option $report Generate an XML report for continuous integration
     */
    public function phpCodeStyle($opts = ['report' => false])
    {
        $report = isset($opts['report']) && $opts['report'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('php:code-style');
        $this->info('Starting code style check for PHP source files');
        $exec = $this->taskExec('php')
            ->arg($paths['bin'].'/phpcs');
        if ($report) {
            $exec->option('report=checkstyle');
            $exec->option('report-file='.$paths['reports'].'/checkstyle.xml');
            $exec->option('warning-severity=0');
        }
        $exec->option('standard='.$paths['build'].'/phpcs.xml')
            ->arg($paths['src'])
            ->printed($report ? false : true)
            ->run();
        $this->info('PHP source files passed code style check');
    }

    /**
     * Performs syntax check on PHP source
     */
    public function phpLint()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('php:lint');
        $this->info('Starting syntax check of PHP source files');
        $iterator = Finder::create()
            ->files()
            ->name('*.php')
            ->in($paths['src']);
        foreach ($iterator as $file) {
            $this->taskExec('php')
                ->arg('-l')
                ->arg($file->getRealPath())
                ->printed(false)
                ->run();
        }
        $this->info('PHP source files passed syntax check');
    }

    /**
     * Performs mess detection on PHP source
     *
     * @param array $opts The options
     *
     * @option $report Generate an XML report for continuous integration
     */
    public function phpMessDetect($opts = ['report' => false])
    {
        $report = isset($opts['report']) && $opts['report'] ? true : false;
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $this->yell('php:mess-detect');
        $this->info('Starting mess detection in PHP source files');
        $exec = $this->taskExec('php')
            ->arg($paths['bin'].'/phpmd')
            ->arg($paths['src'])
            ->arg($report ? 'xml' : 'text')
            ->arg($paths['build'].'/phpmd.xml');
        if ($report) {
            $exec->option('reportfile', $paths['reports'].'/pmd.xml');
        }
        $exec->printed($report ? false : true)
            ->run();
        $this->info('PHP source files passed mess detection');
    }

    /**
     * Runs all PHPUnit test suites
     */
    public function phpTest()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $phpunit = $paths['bin'].'/phpunit';
        $this->yell('php:test');
        $this->info('Running all PHPUnit test suites');
        $this->taskPHPUnit($phpunit)
            ->option('configuration', $paths['build'])
            ->option('testsuite', 'complete')
            ->printed(true)
            ->run();
        $this->info('Project passed all PHPUnit test suites');
    }

    /**
     * Runs PHPUnit functional test suite
     */
    public function phpTestFunc()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $phpunit = $paths['bin'].'/phpunit';
        $this->yell('php:test-func');
        $this->info('Running PHPUnit functional test suite');
        $this->taskPHPUnit($phpunit)
            ->option('configuration', $paths['build'])
            ->option('testsuite', 'functional')
            ->printed(true)
            ->run();
        $this->info('Project passed PHPUnit functional test suite');
    }

    /**
     * Runs PHPUnit integration test suite
     */
    public function phpTestInt()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $phpunit = $paths['bin'].'/phpunit';
        $this->yell('php:test-int');
        $this->info('Running PHPUnit integration test suite');
        $this->taskPHPUnit($phpunit)
            ->option('configuration', $paths['build'])
            ->option('testsuite', 'integration')
            ->printed(true)
            ->run();
        $this->info('Project passed PHPUnit integration test suite');
    }

    /**
     * Runs PHPUnit unit test suite
     */
    public function phpTestUnit()
    {
        $paths = $this->getPaths();
        $this->stopOnFail(true);
        $phpunit = $paths['bin'].'/phpunit';
        $this->yell('php:test-unit');
        $this->info('Running PHPUnit unit test suite');
        $this->taskPHPUnit($phpunit)
            ->option('configuration', $paths['build'])
            ->option('testsuite', 'unit')
            ->printed(true)
            ->run();
        $this->info('Project passed PHPUnit unit test suite');
    }

    //===================================================//
    // Helper Methods                                    //
    //===================================================//
    /**
     * Prints text with info color
     *
     * @param string $message The message
     */
    private function info($message)
    {
        $this->say(sprintf('<fg=blue>%s</fg=blue>', $message));
    }
    /**
     * Retrieves application paths
     *
     * @return array
     */
    private function getPaths()
    {
        if ($this->paths === null) {
            $this->paths = require __DIR__.'/paths.php';
        }
        return $this->paths;
    }
    /**
     * Retrieves filesystem helper
     *
     * @return Filesystem
     */
    private function getFilesystem()
    {
        if ($this->filesystem === null) {
            $this->filesystem = new Filesystem();
        }
        return $this->filesystem;
    }
}
