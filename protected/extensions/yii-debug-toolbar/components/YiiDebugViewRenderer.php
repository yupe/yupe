<?php
/**
 * YiiDebugViewRenderer class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */

/**
 * YiiDebugViewRenderer represents an ...
 *
 * Description of YiiDebugViewRenderer
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @version $Id$
 * @package
 * @since 1.1.7
 */
class YiiDebugViewRenderer extends ProxyComponent
{

    private $_fileExtension = '.php';

    protected $_debugStackTrace = array();

    public function getFileExtension()
    {
        return $this->_fileExtension;
    }

    public function getDebugStackTrace()
    {
        return $this->_debugStackTrace;
    }

    public function renderFile($context, $sourceFile, $data, $return)
    {
        $this->collectDebugInfo($context, $sourceFile, $data);

        if (false !== $this->getIsProxy())
        {
            return $this->instance->renderFile($context,$sourceFile,$data,$return);
        }
         return $context->renderInternal($sourceFile,$data,$return);
    }

    public function generateViewFile($sourceFile, $viewFile)
    {
        if (false !== $this->getIsProxy())
        {
            return $this->instance->generateViewFile($sourceFile, $viewFile);
        }
    }

    protected function collectDebugInfo($context, $sourceFile, $data)
    {
        if(is_a($context, 'YiiDebugToolbar') || false !== ($context instanceof YiiDebugToolbarPanel))
            return;

        $backTrace = debug_backtrace(true);
        $backTraceItem = null;

        while($backTraceItem = array_shift($backTrace))
        {
            if(isset($backTraceItem['object']) && $backTraceItem['object'] && is_a($backTraceItem['object'], get_class($context)) && in_array($backTraceItem['function'], array(
                'render',
                'renderPartial'
            )) )
            {
                break;
            }
        }

        array_push($this->_debugStackTrace, array(
            'context'=>$context,
            'contextProperties'=>  get_object_vars($context),
            'action'=> $context instanceof CController ? $context->action : null,
            'actionParams'=> ($context instanceof CController && method_exists($context, 'getActionParams'))
                ? $context->actionParams
                : null,
            'route'=> $context instanceof CController ? $context->route : null,
            'sourceFile'=>$sourceFile,
            'data'=>$data,
            'backTrace'=>$backTraceItem,
            'reflection' => new ReflectionObject($context)
        ));
    }
    
}