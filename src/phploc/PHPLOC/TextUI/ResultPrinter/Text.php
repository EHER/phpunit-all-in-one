<?php
/**
 * phploc
 *
 * Copyright (c) 2009-2012, Sebastian Bergmann <sb@sebastian-bergmann.de>.
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
 * @package   phploc
 * @author    Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright 2009-2012 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license   http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @since     File available since Release 1.1.0
 */

/**
 * A ResultPrinter for the TextUI.
 *
 * @author    Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @copyright 2009-2012 Sebastian Bergmann <sb@sebastian-bergmann.de>
 * @license   http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @version   Release: 1.6.4
 * @link      http://github.com/sebastianbergmann/phploc/tree
 * @since     Class available since Release 1.0.0
 */
class PHPLOC_TextUI_ResultPrinter_Text
{
    /**
     * Prints a result set.
     *
     * @param array   $count
     * @param boolean $printTests
     */
    public function printResult(array $count, $printTests)
    {
        $args   = array();
        $format = '';

        if ($count['directories'] > 0) {
            $format .= "Directories:                                 %10d\n" .
                       "Files:                                       %10d\n\n";
            $args[]  = $count['directories'];
            $args[]  = $count['files'];
        }

        $format .= "Lines of Code (LOC):                         %10d\n" .
                   "  Cyclomatic Complexity / Lines of Code:     %10.2f\n";
        $args[]  = $count['loc'];
        $args[]  = $count['ccnByLoc'];

        if (isset($count['eloc'])) {
            $format .= "Executable Lines of Code (ELOC):             %10d\n";
            $args[]  = $count['eloc'];
        }

        $format .= "Comment Lines of Code (CLOC):                %10d\n" .
                   "Non-Comment Lines of Code (NCLOC):           %10d\n\n" .
                   "Namespaces:                                  %10d\n" .
                   "Interfaces:                                  %10d\n" .
                   "Traits:                                      %10d\n" .
                   "Classes:                                     %10d\n" .
                   "  Abstract:                                  %10d (%.2f%%)\n" .
                   "  Concrete:                                  %10d (%.2f%%)\n" .
                   "  Average Class Length (NCLOC):              %10d\n" .
                   "Methods:                                     %10d\n" .
                   "  Scope:\n" .
                   "    Non-Static:                              %10d (%.2f%%)\n" .
                   "    Static:                                  %10d (%.2f%%)\n" .
                   "  Visibility:\n" .
                   "    Public:                                  %10d (%.2f%%)\n" .
                   "    Non-Public:                              %10d (%.2f%%)\n" .
                   "  Average Method Length (NCLOC):             %10d\n" .
                   "  Cyclomatic Complexity / Number of Methods: %10.2f\n\n" .
                   "Anonymous Functions:                         %10d\n" .
                   "Functions:                                   %10d\n\n" .
                   "Constants:                                   %10d\n" .
                   "  Global constants:                          %10d\n" .
                   "  Class constants:                           %10d\n";

        $args[] = $count['cloc'];
        $args[] = $count['ncloc'];
        $args[] = $count['namespaces'];
        $args[] = $count['interfaces'];
        $args[] = $count['traits'];
        $args[] = $count['classes'];
        $args[] = $count['abstractClasses'];
        $args[] = $count['classes'] > 0 ? ($count['abstractClasses'] / $count['classes']) * 100 : 0;
        $args[] = $count['concreteClasses'];
        $args[] = $count['classes'] > 0 ? ($count['concreteClasses'] / $count['classes']) * 100 : 0;
        $args[] = $count['nclocByNoc'];
        $args[] = $count['methods'];
        $args[] = $count['nonStaticMethods'];
        $args[] = $count['methods'] > 0 ? ($count['nonStaticMethods'] / $count['methods']) * 100 : 0;
        $args[] = $count['staticMethods'];
        $args[] = $count['methods'] > 0 ? ($count['staticMethods'] / $count['methods']) * 100 : 0;
        $args[] = $count['publicMethods'];
        $args[] = $count['methods'] > 0 ? ($count['publicMethods'] / $count['methods']) * 100 : 0;
        $args[] = $count['nonPublicMethods'];
        $args[] = $count['methods'] > 0 ? ($count['nonPublicMethods'] / $count['methods']) * 100 : 0;
        $args[] = $count['nclocByNom'];
        $args[] = $count['ccnByNom'];
        $args[] = $count['anonymousFunctions'];
        $args[] = $count['functions'];
        $args[] = $count['constants'];
        $args[] = $count['globalConstants'];
        $args[] = $count['classConstants'];

        if ($printTests) {
            $format .= "\nTests:\n  Classes:                                   %10d\n" .
                       "  Methods:                                   %10d\n";
            $args[]  = $count['testClasses'];
            $args[]  = $count['testMethods'];
        }

        vprintf($format, $args);
    }
}
