<?php
/**
 * @author Todd Burry <todd@vanillaforums.com>
 * @copyright 2009-2014 Vanilla Forums Inc.
 * @license MIT
 */

namespace Htmlawed;


class Htmlawed {
    /// Methods ///

    /**
     * Filters a string of html with the htmLawed library.
     *
     * @param string $html The text to filter.
     * @param array $config Config settings for the array.
     * @param string $spec A specification to further limit the allowed attribute values in the html.
     * @return string Returns the filtered html.
     * @see http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm
     */
    public static function filter($html, array $config = [], $spec = '') {
        require_once __DIR__.'/htmLawed/htmLawed.php';

        if (isset($config['spec']) && !$spec) {
            $spec = $config['spec'];
        }

        return htmLawed($html, $config, $spec);
    }


    /**
     * Filter a string of html so that it can be put into an rss feed.
     *
     * @param $html The html text to fitlter.
     * @return string Returns the filtered html.
     * @see Htmlawed::filter().
     */
    public static function filterRSS($html) {
        $config = array(
            'anti_link_spam' => array('`.`', ''),
            'comment' => 1,
            'cdata' => 3,
            'css_expression' => 1,
            'deny_attribute' => 'on*,style,class',
            'elements' => '*-applet-form-input-textarea-iframe-script-style-object-embed-comment-link-listing-meta-noscript-plaintext-xmp',
            'keep_bad' => 0,
            'schemes' => 'classid:clsid; href: aim, feed, file, ftp, gopher, http, https, irc, mailto, news, nntp, sftp, ssh, telnet; style: nil; *:file, http, https', // clsid allowed in class
            'valid_xml' => 2,
            'anti_link_spam' => array('`.`', '')
        );
        $spec = 'object=-classid-type, -codebase; embed=type(oneof=application/x-shockwave-flash)';

        $result = static::filter($html, $config, $spec);

        return $result;
    }
}
 