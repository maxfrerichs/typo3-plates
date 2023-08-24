<?php
declare(strict_types=1);
namespace TYPO3Plates\ContentObject;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\AbstractContentObject;
use League\Plates\Engine;

class PlatesContentObject extends AbstractContentObject {

    protected Engine $engine;

    public function injectPlatesEngine(Engine $engine): void
    {
        $this->engine = $engine;
    }

    public function render($conf = []): string
    {
        $view = $this->getView($conf['templateRootPath']);
        $view->addData(['data' => $this->cObj->data]);
        $templateName = $conf['templateName'] ?? 'default';
        return $view->render($templateName);
    }


    private function getView(string $templateRootPath): Engine
    {
        return $this->engine->setDirectory(GeneralUtility::getFileAbsFileName($templateRootPath));
    }
}
