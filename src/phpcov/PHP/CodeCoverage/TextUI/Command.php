<?php
/**
 * PHP_CodeCoverage
 *
 * Copyright (c) 2011-2012, Sebastian Bergmann <sb@sebastian-bergmann.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sebastian Bergmann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   PHP
 * @package    CodeCoverage
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2011-2012 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/sebastianbergmann/phpcov
 * @since      File available since Release 1.0.0
 */

/**
 * TextUI frontend for PHP_CodeCoverage.
 *
 * @category   PHP
 * @package    CodeCoverage
 * @author     Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright  2011-2012 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version    Release: @package_version@
 * @link       http://github.com/sebastianbergmann/phpcov
 * @since      Class available since Release 1.0.0
 */
class PHP_CodeCoverage_TextUI_Command
{
    /**
     * Main method.
     */
    public static function main()
    {
        $input = new ezcConsoleInput;

        $input->registerOption(
          new ezcConsoleOption(
            '',
            'clover',
            ezcConsoleInput::TYPE_STRING
           )
        );

        $input->registerOption(
          new ezcConsoleOption(
            '',
            'html',
            ezcConsoleInput::TYPE_STRING
           )
        );

        $input->registerOption(
          new ezcConsoleOption(
            '',
            'php',
            ezcConsoleInput::TYPE_STRING
           )
        );

        $input->registerOption(
          new ezcConsoleOption(
            '',
            'text',
            ezcConsoleInput::TYPE_STRING
           )
        );

        $input->registerOption(
          new ezcConsoleOption(
            '',
            'blacklist',
            ezcConsoleInput::TYPE_STRING,
            array(),
            TRUE
           )
        );

        $input->registerOption(
          new ezcConsoleOption(
            '',
            'whitelist',
            ezcConsoleInput::TYPE_STRING,
            array(),
            TRUE
           )
        );

        $input->registerOption(
          new ezcConsoleOption(
            '',
            'merge',
            ezcConsoleInput::TYPE_NONE,
            FALSE
           )
        );

        $input->registerOption(
          new ezcConsoleOption(
            'h',
            'help',
            ezcConsoleInput::TYPE_NONE,
            NULL,
            FALSE,
            '',
            '',
            array(),
            array(),
            FALSE,
            FALSE,
            TRUE
           )
        );

        $input->registerOption(
          new ezcConsoleOption(
            'v',
            'version',
            ezcConsoleInput::TYPE_NONE,
            NULL,
            FALSE,
            '',
            '',
            array(),
            array(),
            FALSE,
            FALSE,
            TRUE
           )
        );

        try {
            $input->process();
        }

        catch (ezcConsoleOptionException $e) {
            print $e->getMessage() . "\n";
            exit(1);
        }

        if ($input->getOption('help')->value) {
            self::showHelp();
            exit(0);
        }

        else if ($input->getOption('version')->value) {
            self::printVersionString();
            exit(0);
        }

        $arguments = $input->getArguments();
        $clover    = $input->getOption('clover')->value;
        $html      = $input->getOption('html')->value;
        $php       = $input->getOption('php')->value;
        $text      = $input->getOption('text')->value;
        $blacklist = $input->getOption('blacklist')->value;
        $whitelist = $input->getOption('whitelist')->value;
        $merge     = $input->getOption('merge')->value;

        if (count($arguments) == 1) {
            self::printVersionString();

            $coverage = new PHP_CodeCoverage;
            $filter   = $coverage->filter();

            if (empty($whitelist)) {
                $c = new ReflectionClass('ezcBase');
                $filter->addDirectoryToBlacklist(dirname($c->getFileName()));
                $c = new ReflectionClass('ezcConsoleInput');
                $filter->addDirectoryToBlacklist(dirname($c->getFileName()));

                foreach ($blacklist as $item) {
                    if (is_dir($item)) {
                        $filter->addDirectoryToBlacklist($item);
                    }

                    else if (is_file($item)) {
                        $filter->addFileToBlacklist($item);
                    }
                }
            } else {
                foreach ($whitelist as $item) {
                    if (is_dir($item)) {
                        $filter->addDirectoryToWhitelist($item);
                    }

                    else if (is_file($item)) {
                        $filter->addFileToWhitelist($item);
                    }
                }
            }

            if (!$merge) {
                $coverage->start('phpcov');

                require $arguments[0];

                $coverage->stop();
            } else {
                $finder = new Symfony\Component\Finder\Finder;
                $finder->in($arguments[0])
                       ->name('*.cov');

                foreach ($finder as $file) {
                    $coverage->merge(
                      unserialize(file_get_contents($file->getRealpath()))
                    );
                }
            }

            if ($clover) {
                $writer = new PHP_CodeCoverage_Report_Clover;
                $writer->process($coverage, $clover);
            }

            if ($html) {
                $writer = new PHP_CodeCoverage_Report_HTML;
                $writer->process($coverage, $html);
            }

            if ($php) {
                $writer = new PHP_CodeCoverage_Report_PHP;
                $writer->process($coverage, $php);
            }

            if ($text) {
                $writer = new PHP_CodeCoverage_Report_Text;
                $writer->process($coverage, $text);
            }
        } else {
            self::showHelp();
            exit(1);
        }
    }

    /**
     * Shows an error.
     *
     * @param string $message
     */
    protected static function showError($message)
    {
        self::printVersionString();

        print $message;

        exit(1);
    }

    /**
     * Shows the help.
     */
    protected static function showHelp()
    {
        self::printVersionString();

        print <<<EOT
Usage: phpcov [switches] <file>
       phpcov --merge [switches] <directory>

  --clover <file>         Generate code coverage report in Clover XML format.
  --html <dir>            Generate code coverage report in HTML format.
  --php <file>            Serialize PHP_CodeCoverage object to file.
  --text <file>           Generate code coverage report in text format.

  --blacklist <dir|file>  Adds <dir|file> to the blacklist.
  --whitelist <dir|file>  Adds <dir|file> to the whitelist.

  --merge                 Merges PHP_CodeCoverage objects stored in .cov files.

  --help                  Prints this usage information.
  --version               Prints the version and exits.

EOT;
    }

    /**
     * Prints the version string.
     */
    protected static function printVersionString()
    {
        print "phpcov @package_version@ by Sebastian Bergmann.\n\n";
    }
}
