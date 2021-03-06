<?php

namespace Theodo\RogerCmsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository
{
    // Homepage slug
    const SLUG_HOMEPAGE   = 'homepage';

    // Page status
    const STATUS_DRAFT    = 'Draft';
    const STATUS_REVIEWED = 'Reviewed';
    const STATUS_PUBLISH  = 'Published';
    const STATUS_HIDDEN   = 'Hidden';

    // Content types
    const TYPE_TEXT_HTML       = 'text/html';
    const TYPE_TEXT_CSS        = 'text/css';
    const TYPE_TEXT_JAVASCRIPT = 'text/javasript';

    // Content subtypes
    const SUBTYPE_TEXT_HTML       = 'html';
    const SUBTYPE_TEXT_CSS        = 'css';
    const SUBTYPE_TEXT_JAVASCRIPT = 'js';

    /**
     * Return list of available status
     *
     * @return array
     *
     * @author Vincent Guillon <vincentg@theodo.fr>
     * @since 2011-06-20
     */
    public static function getAvailableStatus()
    {
        return array(
            self::STATUS_DRAFT    => self::STATUS_DRAFT,
            self::STATUS_REVIEWED => self::STATUS_REVIEWED,
            self::STATUS_PUBLISH  => self::STATUS_PUBLISH,
            self::STATUS_HIDDEN   => self::STATUS_HIDDEN
        );
    }

    /**
     * Return list of available content types
     *
     * @return array
     *
     * @author Vincent Guillon <vincentg@theodo.fr>
     * @since 2011-07-04
     */
    public static function getAvailableContentTypes()
    {
        return array(
            self::TYPE_TEXT_HTML       => self::TYPE_TEXT_HTML,
            self::TYPE_TEXT_CSS        => self::TYPE_TEXT_CSS,
            self::TYPE_TEXT_JAVASCRIPT => self::TYPE_TEXT_JAVASCRIPT
        );
    }

    /**
     * Return list of available content subtypes
     *
     * @return array
     *
     * @author cyrillej
     * @since 2011-07-05
     */
    public static function getAvailableContentSubtypes()
    {
        return array(
            self::TYPE_TEXT_HTML       => self::SUBTYPE_TEXT_HTML,
            self::TYPE_TEXT_CSS        => self::SUBTYPE_TEXT_CSS,
            self::TYPE_TEXT_JAVASCRIPT => self::SUBTYPE_TEXT_JAVASCRIPT
        );
    }

    /**
     * List main pages
     *
     * @return array
     *
     * @author Vincent Guillon <vincentg@theodo.fr>
     * @since 2011-06-20
     */
    public function queryForMainPages()
    {
        // Create sql query
        $sql_query = <<<EOF
SELECT p, c, c2 FROM TheodoRogerCmsBundle:Page p
  LEFT JOIN p.children c
  LEFT JOIN c.children c2
  WHERE p.parentId IS NULL
  ORDER BY p.name
EOF;

        // Create doctrine query
        $query = $this->getEntityManager()->createQuery($sql_query);

        return $query;
    }

    /**
     * @author Mathieu Dähne <mathieud@theodo.fr>
     * @since 2011-06-28
     */
    public function queryHomepage()
    {
        $query = $this->getEntityManager()->createQuery("SELECT p FROM TheodoRogerCmsBundle:Page p WHERE p.parentId IS NULL");

        return $query;
    }

    /**
     * Retrieve the homepage
     *
     * @author Mathieu Dähne <mathieud@theodo.fr>
     * @since 2011-06-28
     */
    public function getHomepage()
    {
      $query = $this->queryHomepage();

      return $query->getSingleResult();
    }
}
