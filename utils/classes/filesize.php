<?php
/**
 * MIT License
 * ===========
 *
 * Copyright (c) 2012 Asad Haider <asad@asadhaider.co.uk>
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
 * CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package     FileEasy-Upload-Script
 * @author      Asad Haider <asad@asadhaider.co.uk>
 * @copyright   2012 Asad Haider.
 * @link        http://asadhaider.co.uk
 * @version     1.0.0
 */

class getFileSize {
    private $size;
    
    function __construct() {
        $this->size = array(
            array(
                'minSize' => '1073741824',
                'unit' => 'GB',
                'rank' => '4'
            ),
            array(
                'minSize' => '1048576',
                'unit' => 'MB',
                'rank' => '3'
            ),
            array(
                'minSize' => '1024',
                'unit' => 'KB',
                'rank' => '2'
            ),
            array(
                'minSize' => '0',
                'unit' => 'B',
                'rank' => '1'
            )
        );
    }
    
    function fileSizeByFileName($fileName, $roundOff = '2') {
        $fileSize = filesize($fileName);
        foreach($this->size as $key => $result) {
            if( $fileSize >= $result['minSize'] ) {
                $requiredUnitRank = $result['rank'];
                $requiredUnit = $result['unit'];
                $requiredMinSize = $result['minSize'];
                break;
            }
        }
        
        $finalSize = number_format( ( $fileSize / $requiredMinSize ),$roundOff );
        
        return $finalSize . ' ' . $requiredUnit;
        
    }
    
    function fileSizeConversion($fileSize, $currentUnit = 'B', $requiredUnit = '', $roundOff = '2') {
        foreach($this->size as $key => $result) {
            if(  $result['unit'] ==  strtoupper($currentUnit) ) {
                $currentUnitRank = $result['rank'];
                $currentMinSize = $result['minSize'];
            }
        }
        if($requiredUnit == '') {
            foreach($this->size as $key => $result) {
                if( $fileSize >= $result['minSize'] ) {
                    $requiredUnitRank = $result['rank'];
                    $requiredUnit = $result['unit'];
                    $requiredMinSize = $result['minSize'];
                    break;
                }
            }
        } else {
            foreach($this->size as $key => $result) {
                if(  $result['unit'] ==  strtoupper($requiredUnit) ) {
                    $requiredUnitRank = $result['rank'];
                    $requiredUnit = $result['unit'];
                    $requiredMinSize = $result['minSize'];
                }
            }
        }
        
        if($requiredUnitRank > $currentUnitRank) {
            $diffRank = $requiredUnitRank - $currentUnitRank;
            $calculationSize = ( $currentMinSize == 0) ? 1 : $currentMinSize ;
            for($start = 1; $start <= $diffRank; $start++)
            $calculationSize = $calculationSize * 1024;
            
            $finalSize = number_format( ( $fileSize / $calculationSize ), $roundOff );
            
        } else if ($requiredUnitRank < $currentUnitRank) {
            $finalSize = number_format( ( ($fileSize * $currentMinSize) / $requiredMinSize), $roundOff );
        } else {
            $finalSize = $fileSize;
        }
        
       return $finalSize . ' ' . $requiredUnit;
    }
};
?>