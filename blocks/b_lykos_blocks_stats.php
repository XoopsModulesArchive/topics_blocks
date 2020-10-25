 <?php
 // ------------------------------------------------------------------------- //
 //                XOOPS - PHP Content Management System                      //
 //                       <https://www.xoops.org>                             //
 // ------------------------------------------------------------------------- //
 // Based on:                             //
 // myPHPNUKE Web Portal System - http://myphpnuke.com/              //
 // PHP-NUKE Web Portal System - http://phpnuke.org/              //
 // Thatware - http://thatware.org/                   //
 // ------------------------------------------------------------------------- //
 //  This program is free software; you can redistribute it and/or modify     //
 //  it under the terms of the GNU General Public License as published by     //
 //  the Free Software Foundation; either version 2 of the License, or        //
 //  (at your option) any later version.                                      //
 //                                                                           //
 //  This program is distributed in the hope that it will be useful,          //
 //  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
 //  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
 //  GNU General Public License for more details.                             //
 //                                                                           //
 //  You should have received a copy of the GNU General Public License        //
 //  along with this program; if not, write to the Free Software              //
 //  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
 // ------------------------------------------------------------------------- //

function b_lykos_blocks_stats_show()
{
    global $xoopsDB;

    $block = [];

    $sql = 'SELECT dirname FROM ' . $xoopsDB->prefix('modules') . " WHERE isactive='1'";

    $result = $xoopsDB->query($sql);

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $stats = [];

        if ('mylinks' == $myrow['dirname']) {
            $resultl = $xoopsDB->query('SELECT lid, hits FROM ' . $xoopsDB->prefix('mylinks_links') . ' WHERE status >0 ORDER BY lid');

            $thecount = 0;

            $total = 0;

            while (list($id, $hit) = $xoopsDB->fetchRow($resultl)) {
                $thecount++;

                $total += $hit;
            }

            $stats['count'] = $thecount;

            $stats['total'] = $total;

            $stats['name1'] = 'Links';

            $stats['name2'] = 'hits';

            $block['stats'][] = $stats;
        }

        if ('mydownloads' == $myrow['dirname']) {
            $resultd = $xoopsDB->query('SELECT lid, hits FROM ' . $xoopsDB->prefix('mydownloads_downloads') . ' WHERE status >0 ORDER BY lid');

            $thecount = 0;

            $total = 0;

            while (list($id, $hit) = $xoopsDB->fetchRow($resultd)) {
                $thecount++;

                $total += $hit;
            }

            $stats['count'] = $thecount;

            $stats['total'] = $total;

            $stats['name1'] = 'Downloads';

            $stats['name2'] = 'hits';

            $block['stats'][] = $stats;
        }

        if ('lykos_reviews' == $myrow['dirname']) {
            $resultr = $xoopsDB->query('SELECT review_id, review_hits FROM ' . $xoopsDB->prefix('lykos_reviews_contents') . " WHERE review_visible='1' ORDER BY review_id");

            $thecount = 0;

            $total = 0;

            while (list($id, $hit) = $xoopsDB->fetchRow($resultr)) {
                $count++;

                $total += $hit;
            }

            $stats['count'] = $thecount;

            $stats['total'] = $total;

            $stats['name1'] = 'Reviews';

            $stats['name2'] = 'hits';

            $block['stats'][] = $stats;
        }

        if ('news' == $myrow['dirname']) {
            $resultn = $xoopsDB->query('SELECT storyid, counter FROM ' . $xoopsDB->prefix('stories') . ' WHERE published<' . time() . ' AND published>0 ORDER BY storyid');

            $thecount = 0;

            $total = 0;

            while (list($id, $hit) = $xoopsDB->fetchRow($resultn)) {
                $thecount++;

                $total += $hit;
            }

            $stats['count'] = $thecount;

            $stats['total'] = $total;

            $stats['name1'] = 'News items';

            $stats['name2'] = 'hits';

            $block['stats'][] = $stats;
        }

        if ('wfsection' == $myrow['dirname']) {
            $resultwf = $xoopsDB->query('SELECT articleid, counter, published, expired FROM ' . $xoopsDB->prefix('wfs_article') . ' WHERE published < ' . time() . ' AND published > 0 AND (expired = 0 OR expired > ' . time() . ') AND noshowart = 0 AND offline = 0 ORDER BY articleid');

            $thecount = 0;

            $total = 0;

            while (list($id, $hit, $pub, $exp) = $xoopsDB->fetchRow($resultwf)) {
                $thecount++;

                $total += $hit;
            }

            $stats['count'] = $thecount;

            $stats['total'] = $total;

            $stats['name1'] = 'Articles';

            $stats['name2'] = 'hits';

            $block['stats'][] = $stats;
        }
    }

    $resultn = $xoopsDB->query('SELECT uid, posts FROM ' . $xoopsDB->prefix('users') . ' WHERE level>0');

    $thecount = 0;

    $total = 0;

    while (list($id, $hit) = $xoopsDB->fetchRow($resultn)) {
        $thecount++;

        $total += $hit;
    }

    $stats2['count'] = $thecount;

    $stats2['total'] = $total;

    $stats2['name1'] = 'Users';

    $stats2['name2'] = 'posts';

    $block['stats'][] = $stats2;

    return $block;
}
