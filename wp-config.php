<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung 
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt, 
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define( 'DB_NAME', 'ngchihieuu' );

/** Username của database */
define( 'DB_USER', 'root' );

/** Mật khẩu của database */
define( 'DB_PASSWORD', '' );

/** Hostname của database */
define( 'DB_HOST', 'localhost' );

/** Database charset sử dụng để tạo bảng database. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '4#^Id) gSEr7oHFGIDR]1{q=EhN93IS(0Bqn)Qr!PX)Y{6fw$C;NMx[gc?OpH >]' );
define( 'SECURE_AUTH_KEY',  'M++*Tkj|c`4,N!$nB:YgOb8.[YC_W;/#I}R-Zuo+BH9KF1(9MAi3 ZJ2<0/I_I@k' );
define( 'LOGGED_IN_KEY',    '=z0T./P-9bGq=Dbb?Cbl_Lko+OZ)xlQf`gGxi4Q-[+AH#nH,.n1vU!n2*.+VM=[f' );
define( 'NONCE_KEY',        '<NC0NW?hpUMwUL++lH{qgA7DN!D-TEih=@mh,YNR1{D%x{85zhLuH![P?iHDEByJ' );
define( 'AUTH_SALT',        ' w$yW3/5hR!mlH8[w1qBVu+;6De+LJVc}:*+_n1g@+7DfS{p3D9TKO1qj)To3H%-' );
define( 'SECURE_AUTH_SALT', 'X-IylE@I7^oEthO#?=M,V+]^|N4oB#PeQS4YaLEERO%dZQv`|CXNoe!ooNgI?|RB' );
define( 'LOGGED_IN_SALT',   'BDva7W63qQ~c<,q1g[oISb~c/,ovK@SYU;-i4V}K8M:({GhyhJ&q[`93Jm%Gc$XG' );
define( 'NONCE_SALT',       'dhV1@-RWB lp-Si0H:>9L^i24hsq6gqmA#Ki>ie>fR+3D&/X)5zi)F!xA+7B?psK' );

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix  = 'wp_';

/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
