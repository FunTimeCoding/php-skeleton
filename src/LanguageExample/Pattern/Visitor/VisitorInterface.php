<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\Visitor;

interface VisitorInterface
{
    /**
     * @param NodeInterface $node
     * @return void
     */
    public function visit(NodeInterface $node);
}
