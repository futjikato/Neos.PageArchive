<?php

namespace Futjikato\PageArchive\Security\Authorization\Privilege;

use TYPO3\Flow\Security\Authorization\Privilege\Method\MethodPrivilegeSubject;
use TYPO3\Flow\Security\Authorization\Privilege\PrivilegeSubjectInterface;
use TYPO3\Flow\Security\Exception\InvalidPrivilegeTypeException;
use TYPO3\Neos\Security\Authorization\Privilege\NodeTreePrivilege;
use TYPO3\TYPO3CR\Security\Authorization\Privilege\Node\NodePrivilegeSubject;

/**
 * Privilege to match archived page nodes
 */
class ArchiveNodeTreePrivilege extends NodeTreePrivilege
{
    /**
     * Matches only archived page nodes.
     * Only nodes with pageArchive property wil match
     *
     * @param PrivilegeSubjectInterface|NodePrivilegeSubject|MethodPrivilegeSubject $subject
     *
     * @return boolean
     * @throws InvalidPrivilegeTypeException
     */
    public function matchesSubject(PrivilegeSubjectInterface $subject)
    {
        $parentMatch = parent::matchesSubject($subject);

        if (!$parentMatch) {
            return false;
        }

        // must allow to enable save into archive
        // FIXME: this is just horrible
        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            return false;
        }

        // FIXME: move to custom Context
        $node = $subject->getNode();
        if ($node->hasProperty('pageArchive')) {
            return $node->getProperty('pageArchive');
        }

        return false;
    }
}