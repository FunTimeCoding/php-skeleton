<?php
namespace FunTimeCoding\PhpSkeleton\LanguageExample\Pattern\Visitor;

interface NodeInterface
{
    /**
     * @param VisitorInterface $visitor
     * @return void
     */
    public function accept(VisitorInterface $visitor);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @return NodeInterface[]
     */
    public function getChildren();
}
