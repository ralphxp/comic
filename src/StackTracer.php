<?php 
namespace Codx\Comic;


class StackTracer
{
    public static function trace()
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        
        $caller = isset($trace[1]) ? $trace[1] : null;
        $callerClass = isset($caller['class']) ? $caller['class'] : null;
        $callerFunction = isset($caller['function']) ? $caller['function'] : null;
        $callerFile = isset($caller['file']) ? $caller['file'] : null;
        $callerLine = isset($caller['line']) ? $caller['line'] : null;
        
        $current = isset($trace[0]) ? $trace[0] : null;
        $currentFile = isset($current['file']) ? $current['file'] : null;
        $currentLine = isset($current['line']) ? $current['line'] : null;

        return [
            'caller' => [
                'class' => $callerClass,
                'function' => $callerFunction,
                'file' => $callerFile,
                'line' => $callerLine
            ],
            'current' => [
                'file' => $currentFile,
                'line' => $currentLine
            ]
        ];
    }
}
