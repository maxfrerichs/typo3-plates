<?php

declare(strict_types=1);

namespace TYPO3Plates\ContentObject;

use League\Plates\Engine;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\AbstractContentObject;
use TYPO3\CMS\Frontend\ContentObject\ContentDataProcessor;

class PlatesContentObject extends AbstractContentObject
{
    public function __construct(
        protected Engine $engine,
        protected ContentDataProcessor $contentDataProcessor
    ) {
    }

    /**
     * @param array $conf
     * @return string
     */
    public function render($conf = []): string
    {
        $templateRootPath = $this->getTemplateRootPath($conf);
        $view = $this->getView($templateRootPath);
        $variables = $this->getContentObjectVariables($conf);
        $variables = $this->contentDataProcessor->process($this->cObj, $conf, $variables);
        $view->addData($variables);
        return $view->render($this->getTemplateName($conf), $variables);
    }

    /**
     * @return Engine
     */
    protected function getView(string $templateRootPath): Engine
    {
        return $this->engine->setDirectory($templateRootPath);
    }

    /**
     * @param array $conf
     * @return string
     */
    protected function getTemplateRootPath(array $conf): string
    {
        if ($conf['templateRootPath']) {
            return GeneralUtility::getFileAbsFileName($conf['templateRootPath']);
        }
        throw new \InvalidArgumentException(
            'Specified "' . $conf['templateRootPath'] . '" is invalid',
            1288095721
        );
    }

    /**
     * @param array $conf
     * @return string
     */
    protected function getTemplateName(array $conf): string
    {
        return $templateName = $conf['templateName'] ?? 'default';
    }

    /**
     * @param array $conf Configuration array
     * @return array the variables to be assigned
     * @throws \InvalidArgumentException
     */
    protected function getContentObjectVariables(array $conf): array
    {
        $variables = [];
        $reservedVariables = ['data', 'current'];
        // Accumulate the variables to be process and loop them through cObjGetSingle
        $variablesToProcess = (array)($conf['variables.'] ?? []);
        foreach ($variablesToProcess as $variableName => $cObjType) {
            if (is_array($cObjType)) {
                continue;
            }
            if (!in_array($variableName, $reservedVariables)) {
                $cObjConf = $variablesToProcess[$variableName . '.'] ?? [];
                $variables[$variableName] = $this->cObj->cObjGetSingle($cObjType, $cObjConf, 'variables.' . $variableName);
            } else {
                throw new \InvalidArgumentException(
                    'Cannot use reserved name "' . $variableName . '" as variable name in FLUIDTEMPLATE.',
                    1288095720
                );
            }
        }
        $variables['data'] = $this->cObj->data;
        $variables['current'] = $this->cObj->data[$this->cObj->currentValKey ?? null] ?? null;
        return $variables;
    }

    /**
     * Apply the famous standard wrap to content. I don't have any idea if this works
     *
     * @param string $content Rendered HTML content
     * @param array $conf Configuration array
     * @return string Standard wrapped content
     */
    protected function applyStandardWrapToRenderedContent($content, array $conf): ?string
    {
        if (isset($conf['stdWrap.'])) {
            $content = $this->cObj->stdWrap($content, $conf['stdWrap.']);
        }
        return $content;
    }
}
