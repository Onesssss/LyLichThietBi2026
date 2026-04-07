-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 04, 2026 lúc 04:32 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlythietbi`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `full_name`, `role_id`, `branch_id`, `dept_id`, `status`) VALUES
(1, 'đường sắt', '123123', 'duongsat@gmail.com', 'duongsat', 2, 3, 6, 1),
(3, 'demo', '321321', 'demo@gmail.com', 'demo', 1, 3, 6, 1),
(5, 'admin', '123456', 'admin@test.com', 'Administrator', 0, 1, 6, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `approval_histories`
--

CREATE TABLE `approval_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pending_table` varchar(100) NOT NULL,
  `pending_id` bigint(20) UNSIGNED NOT NULL,
  `action_type` varchar(20) NOT NULL,
  `action_result` varchar(20) NOT NULL,
  `approved_by` bigint(20) UNSIGNED NOT NULL,
  `approved_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rejection_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `branches`
--

INSERT INTO `branches` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Xí Nghiệp Thuận Hải', '2026-03-21 10:25:03', '2026-03-21 10:25:03'),
(2, 'Xí Nghiệp Phú Khánh', '2026-03-31 15:35:45', '2026-03-31 15:35:45'),
(3, 'Xí Nghiệp Sài Gòn', '2026-03-31 15:35:55', '2026-03-31 15:35:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `departments`
--

INSERT INTO `departments` (`id`, `branch_id`, `name`, `created_at`, `updated_at`) VALUES
(3, 1, 'Cung Tháp Chàm', '2026-03-21 10:25:43', '2026-03-21 10:25:43'),
(4, 1, 'Cung Cà Ná', '2026-03-31 15:36:16', '2026-03-31 15:36:16'),
(5, 1, 'Cung Vĩnh Hảo', '2026-03-31 15:36:32', '2026-03-31 15:36:32'),
(6, 3, 'Cung Sài Gòn', '2026-03-31 16:11:33', '2026-04-04 12:57:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `equipment_categories`
--

CREATE TABLE `equipment_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `list_id` bigint(20) UNSIGNED NOT NULL,
  `point_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Hoạt động, 0: Vô hiệu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `equipment_categories`
--

INSERT INTO `equipment_categories` (`id`, `name`, `list_id`, `point_id`, `status`, `created_at`, `updated_at`) VALUES
(11, 'Thiết bị thông tin số', 13, 4, 1, '2026-04-04 13:04:07', '2026-04-04 13:04:34'),
(12, 'Thiết bị thông tin tương tự', 13, 4, 1, '2026-04-04 13:04:57', '2026-04-04 13:04:57'),
(13, 'Tín hiệu ra vào ga', 14, 4, 1, '2026-04-04 13:05:27', '2026-04-04 13:05:27'),
(14, 'Thiết bị quay ghi', 14, 4, 1, '2026-04-04 13:05:50', '2026-04-04 13:05:50'),
(15, 'Thiết bị quay ghi', 14, 4, 1, '2026-04-04 13:06:11', '2026-04-04 13:06:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `equipment_items`
--

CREATE TABLE `equipment_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `point_id` int(11) NOT NULL,
  `material` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `manufacture_year` int(11) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `condition` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Tốt, 2: Trung bình, 3: Hỏng',
  `note` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Hoạt động, 0: Vô hiệu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `equipment_items`
--

INSERT INTO `equipment_items` (`id`, `name`, `category_id`, `point_id`, `material`, `unit`, `quantity`, `manufacture_year`, `expiry_date`, `condition`, `note`, `status`, `created_at`, `updated_at`) VALUES
(14, 'Đồng hồ điều độ số', 11, 4, NULL, 'Cái', 1, 2005, NULL, 1, NULL, 1, '2026-04-04 13:07:39', '2026-04-04 13:07:39'),
(15, 'Bàn điều độ trực ban ga', 11, 4, NULL, 'Máy', 2, NULL, NULL, 1, 'Điều độ, trực ban chạy tàu', 1, '2026-04-04 13:11:51', '2026-04-04 13:11:51'),
(16, 'Máy điện thoại nam châm', 12, 4, NULL, 'Cái', 2, NULL, NULL, 1, NULL, 1, '2026-04-04 13:12:53', '2026-04-04 13:12:53'),
(17, 'Phân cơ chọn số âm tần', 12, 4, NULL, 'Bộ', 1, NULL, NULL, 1, NULL, 1, '2026-04-04 13:13:38', '2026-04-04 13:13:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `equipment_lists`
--

CREATE TABLE `equipment_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `point_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Hoạt động, 0: Vô hiệu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `equipment_lists`
--

INSERT INTO `equipment_lists` (`id`, `point_id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(13, 4, 'Thiết bị thông tin', NULL, 1, '2026-04-04 13:02:47', '2026-04-04 13:02:47'),
(14, 4, 'Thiết bị tín hiệu', NULL, 1, '2026-04-04 13:03:19', '2026-04-04 13:03:19'),
(15, 4, 'Thiết bị khác', NULL, 1, '2026-04-04 13:03:46', '2026-04-04 13:03:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2026_03_18_002025_create_sessions_table', 1),
(6, '2026_03_30_181721_create_equipment_lists_table', 2),
(7, '2026_03_30_184030_create_equipment_categories_table', 3),
(8, '2026_03_31_001939_create_equipment_items_table', 4),
(10, '2026_03_31_003053_create_points_table', 5),
(11, '2026_03_31_103739_add_point_id_to_equipment_lists_table', 6),
(12, '2026_03_31_111517_add_point_id_to_equipment_categories_table', 7),
(13, '2026_04_03_235023_create_pending_equipment_lists_table', 8),
(14, '2026_04_03_235042_create_pending_equipment_categories_table', 9),
(15, '2026_04_03_235055_create_pending_equipment_items_table', 10),
(16, '2026_04_03_235423_create_notifications_table', 11),
(17, '2026_04_03_235729_create_approval_histories_table', 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `related_id` bigint(20) UNSIGNED DEFAULT NULL,
  `related_table` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `related_id`, `related_table`, `is_read`, `created_at`) VALUES
(11, 5, 'Yêu cầu duyệt mới', 'Có yêu cầu thêm mới danh mục thiết bị. Vui lòng kiểm tra.', 'approval_request', 2, 'equipment_categories', 1, '2026-04-04 12:44:19'),
(13, 5, 'Yêu cầu duyệt mới', 'Có yêu cầu thêm mới danh mục thiết bị. Vui lòng kiểm tra.', 'approval_request', 3, 'equipment_categories', 1, '2026-04-04 12:51:41'),
(15, 5, 'Yêu cầu duyệt mới', 'Có yêu cầu thêm mới thiết bị. Vui lòng kiểm tra.', 'approval_request', 4, 'equipment_items', 1, '2026-04-04 12:52:29'),
(16, 5, 'Yêu cầu duyệt mới', 'Có yêu cầu thêm mới thiết bị. Vui lòng kiểm tra.', 'approval_request', 5, 'equipment_items', 1, '2026-04-04 12:52:44'),
(19, 5, 'Yêu cầu duyệt mới', 'Có yêu cầu thêm mới dữ liệu equipment_lists. Vui lòng kiểm tra.', 'approval_request', 2, 'equipment_lists', 1, '2026-04-04 13:43:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets_admin`
--

CREATE TABLE `password_resets_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_requests`
--

CREATE TABLE `password_reset_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: chờ xử lý, 1: đã xử lý',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed_at` timestamp NULL DEFAULT NULL,
  `processed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pending_equipment_categories`
--

CREATE TABLE `pending_equipment_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `original_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `list_id` bigint(20) UNSIGNED NOT NULL,
  `point_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `action_type` enum('create','update','delete') NOT NULL DEFAULT 'create',
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pending_equipment_categories`
--

INSERT INTO `pending_equipment_categories` (`id`, `original_id`, `name`, `list_id`, `point_id`, `description`, `status`, `action_type`, `approval_status`, `requested_by`, `requested_at`, `approved_by`, `approved_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, NULL, 'a', 9, 3, NULL, 1, 'create', 'rejected', 1, '2026-04-03 17:32:43', 5, '2026-04-04 09:16:27', 'zzz', '2026-04-03 17:32:43', '2026-04-04 09:16:27'),
(2, NULL, 'teestttt', 8, 7, NULL, 1, 'create', 'approved', 1, '2026-04-04 12:44:19', 5, '2026-04-04 12:44:39', NULL, '2026-04-04 12:44:19', '2026-04-04 12:44:39'),
(3, NULL, 'A2', 8, 7, NULL, 1, 'create', 'approved', 1, '2026-04-04 12:51:41', 5, '2026-04-04 12:52:00', NULL, '2026-04-04 12:51:41', '2026-04-04 12:52:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pending_equipment_items`
--

CREATE TABLE `pending_equipment_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `original_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `point_id` bigint(20) UNSIGNED NOT NULL,
  `material` varchar(100) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `manufacture_year` int(11) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `condition` tinyint(4) NOT NULL DEFAULT 1,
  `note` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `action_type` enum('create','update','delete') NOT NULL DEFAULT 'create',
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pending_equipment_items`
--

INSERT INTO `pending_equipment_items` (`id`, `original_id`, `name`, `category_id`, `point_id`, `material`, `unit`, `quantity`, `manufacture_year`, `expiry_date`, `condition`, `note`, `status`, `action_type`, `approval_status`, `requested_by`, `requested_at`, `approved_by`, `approved_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Phú Khánh 1', 5, 4, NULL, NULL, 0, NULL, NULL, 1, NULL, 1, 'create', 'approved', 1, '2026-04-04 08:46:24', 5, '2026-04-04 09:26:33', NULL, '2026-04-04 08:46:24', '2026-04-04 09:26:33'),
(2, NULL, 'Hòa Trinh Test', 8, 7, 'Nhôm', 'Cái', 1, 2025, '2026-04-07', 1, NULL, 1, 'create', 'approved', 1, '2026-04-04 10:13:48', 5, '2026-04-04 10:14:26', NULL, '2026-04-04 10:13:48', '2026-04-04 10:14:26'),
(3, 12, 'Hòa Trinh Test edit', 8, 7, 'Nhôm', 'Cái', 1, 2025, '2026-04-07', 1, NULL, 1, 'update', 'approved', 1, '2026-04-04 10:14:53', 5, '2026-04-04 10:15:13', NULL, '2026-04-04 10:14:53', '2026-04-04 10:15:13'),
(4, NULL, 'Hòa Trinh Test edit', 10, 7, 'abc', 'Cái', 1, NULL, '2026-04-07', 1, NULL, 1, 'create', 'approved', 1, '2026-04-04 12:52:29', 5, '2026-04-04 12:53:51', NULL, '2026-04-04 12:52:29', '2026-04-04 12:53:51'),
(5, NULL, 'A1', 10, 7, 'Nhôm', 'Máy', 1, NULL, NULL, 1, NULL, 1, 'create', 'rejected', 1, '2026-04-04 12:52:44', 5, '2026-04-04 12:53:47', 'nguu', '2026-04-04 12:52:44', '2026-04-04 12:53:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pending_equipment_lists`
--

CREATE TABLE `pending_equipment_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `original_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `point_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `action_type` enum('create','update','delete') NOT NULL DEFAULT 'create',
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `requested_by` bigint(20) UNSIGNED NOT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pending_equipment_lists`
--

INSERT INTO `pending_equipment_lists` (`id`, `original_id`, `name`, `point_id`, `description`, `status`, `action_type`, `approval_status`, `requested_by`, `requested_at`, `approved_by`, `approved_at`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Thiết bị truyền dẫn', 3, 'abc', 1, 'create', 'approved', 1, '2026-04-03 17:15:17', 5, '2026-04-04 09:25:32', NULL, '2026-04-03 17:15:17', '2026-04-04 09:25:32'),
(2, NULL, 'A1', 4, NULL, 1, 'create', 'rejected', 1, '2026-04-04 13:43:26', 5, '2026-04-04 13:44:04', 'sai', '2026-04-04 13:43:26', '2026-04-04 13:44:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `points`
--

CREATE TABLE `points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `points`
--

INSERT INTO `points` (`id`, `name`, `code`, `department_id`, `order`, `status`, `created_at`, `updated_at`) VALUES
(2, 'TTTH Phước Nhơn', 'Phước Nhơn', 3, 1, 1, '2026-03-30 18:00:19', '2026-04-04 13:00:15'),
(3, 'TTTH Kà Rôm', 'Ka Rôm', 3, 1, 1, '2026-03-31 04:03:46', '2026-04-04 13:00:07'),
(4, 'TTTH ga Bình Triệu', 'Bình Triệu', 6, 1, 1, '2026-03-31 16:11:56', '2026-04-04 12:59:59'),
(8, 'TTTH Gò Vấp', 'Gò Vấp', 6, 1, 1, '2026-04-04 13:00:55', '2026-04-04 13:00:55'),
(9, 'TTTH Sài Gòn', 'Sài Gòn', 6, 1, 1, '2026-04-04 13:01:30', '2026-04-04 13:01:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('64zeeGwmxi0BTg3jacuHgneYaQxtg9PdGPaDvAzi', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiWTQ5N0lDUmpZaWFya011VlN5VGdCaWRwaUx3anVTNmE4U1dxelRnNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775311320),
('7zlQDG6lL7FBFDk7WQTnQ1lRY794jRHkSYUO7dSe', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiUFRZWktMV3FKSHcwU0ZYbXAzUVR2VktIZHJBaXBRTDNYb0Q5bnk4YSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775306631),
('8StY1koPrtXyNGojfD0eWaAJY2FFBmo8A9ElWxx6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoick1jd1BYR0dJN2lzUHZGdVhMaldXUHRPbFRyM0ZEU0M3bnBDVnBJdCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775310921),
('AY6qy4vYfc9nq0egBBue1P8uZcBIyfM9oFg998KO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoibHRQaDllM2VWdzA0REx3REhVMWpRbWppOFptUUx6Nk9NOHg0NU9xOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775309988),
('Ck6L0V33e0AXBiZCToPG07a1PNFE70t6g7Gp7hSH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YToxNTp7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IkM5UW5Xb3FEYktRczU0czYxZ0FxMzFDRGFrdDNramsxeDFzT2MyVEUiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZXF1aXBtZW50LWl0ZW1zL2NyZWF0ZSI7czo1OiJyb3V0ZSI7czoyMjoiZXF1aXBtZW50LWl0ZW1zLmNyZWF0ZSI7fXM6NzoidXNlcl9pZCI7aToxO3M6ODoidXNlcm5hbWUiO3M6MTU6IsSRxrDhu51uZyBz4bqvdCI7czo4OiJmdWxsbmFtZSI7czo4OiJkdW9uZ3NhdCI7czo1OiJlbWFpbCI7czoxODoiZHVvbmdzYXRAZ21haWwuY29tIjtzOjc6InJvbGVfaWQiO2k6MjtzOjk6ImJyYW5jaF9pZCI7aTozO3M6NzoiZGVwdF9pZCI7aTo2O3M6OToibG9nZ2VkX2luIjtiOjE7czo3OiJ1c2VyX2lwIjtzOjk6IjEyNy4wLjAuMSI7czoxMDoidXNlcl9hZ2VudCI7czoxMjU6Ik1vemlsbGEvNS4wIChXaW5kb3dzIE5UIDEwLjA7IFdpbjY0OyB4NjQpIEFwcGxlV2ViS2l0LzUzNy4zNiAoS0hUTUwsIGxpa2UgR2Vja28pIENocm9tZS8xNDYuMC4wLjAgU2FmYXJpLzUzNy4zNiBFZGcvMTQ2LjAuMC4wIjtzOjc6ImNyZWF0ZWQiO2k6MTc3NTMxMTMyNTtzOjEzOiJsYXN0X2FjdGl2aXR5IjtpOjE3NzUzMTEzMjU7fQ==', 1775311360),
('dF57DOMISrIN9ZxNKWnzLXi0Kk0i8OypTBgp32iB', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiWFpSTW83NzRBakZldU5XcnhXVDFuQjNtYjVrVkxJdHh6MDBJejgyaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775307123),
('ecJeznJ1zaC2OHGcsftscJDXunibZHB8MvDA3n9o', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoicU43NUU5ak5Ub3plaUMwV1o4MEJzRVRLbE5nYWpXSXJub0Z5aFNPUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775306979),
('hC6sjMaPdTT8LKgZGJdpw3UBbT35RzLzBQ7wJDnL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiejlqYnRFV1RCSjg5Q3NRNU1hREpxOTdqR0dYVnJZSkpZNVJQWjJDMSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775310212),
('IEGUebCLzoFfroTBo6qTDA5jKjhvXFRfjIl1wFr5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiYjFCM2xxQ3QxaTN0TGZNTnJESXcyMHNycGk1MThTaUY0UzR5TUtMeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775311207),
('Iobex79cNwSpDJ0QzAEtjbB56UckyU7GfWQH5CnE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiVVRlaXBreEhYMDZXSVZJUzhHSE4xWnpXM2RicXZRQVJYVnJVYVN1MCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775307166),
('oqClkaWMjV4DaruoKSyurs4XuGDjUiRteSzfgTcC', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiUkFrcWxLUVJKclhOdDVNb29STWxaSTI0emJPNlA2dVJQVGRsUEVyTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775307103),
('QyzzKPkC4BB3dLDWV31e50zuCSNleHLgmCKc9gjt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiMlU0TGNzZHZtOXVrZFkzQmJJZDdkbFFMTEJVQnd3UnVwdnN1M3FWVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775310903),
('rK9l7uRC5X6xUJSCeGwSJdOKlIkiF6UZfyxL9yPJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiT3hkdlpzRzdNUWtGUmhnZXdLY2FxbHh1WDZQUkFhaVRJRUxXZGJTTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775310246),
('rrnP5kzmsSzD67D1YiKTVCr26OahVHmDoAvEJC4T', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiVEY4VGwzajU4VUJsQU9mb1FHN25KYUtZZGJnajNRbUZ3MUJPcEEySiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775306662),
('Untm92Wn4H0cb6eZPbL79SHUj0K0Zo241dgBeu8z', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoicmt0Nm9CRlNDZTgzV0E3c0tZZll1b0V5a3IwN0tYa1R3aVNodnJVSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775310948),
('wcIAQ7YMxUmhkiD2DEl3Z7mwdpdhFXGuTcHOoAmu', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiMkVac1BiOHRQV1pBeThpSWhsaUlFOEpJc1NPbGczMkt0WXZYc3FJSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775307268),
('xvO3ulxVae3hnRw3agTgDJUsI4Y6zFUSyjyxh0hU', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiVWpmcEVHSk55YVdRVGUwMzl1M2s0RkFHWUROZDJ3cTdPdlM2TmIzVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775310168),
('YTalOBbvqtqHHUddg2Lc7TimazmmR5lPqgmjlIO3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiRjY5MnFoU3V5dkVQTlVCeHhQNTg2YTNHQmo1Rkc1SHBtZ0h4QkdRdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775307238),
('YxjyCUZu6eW0atMQEJQHE2PJuj3PTRldHCJmXg2W', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiNWx3enU0NmxZeXJtWnJzN1pEc2VuR1lLOXZ3eFBVSlNIV1h0eUQ3UCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775311273),
('zu9sUj6R29mayFMbLTpDxejCJYU0dejeTYUtejLP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoia0dpa0FvT3VBeHloUGdQcGdDMlJDMklhRnZTRWV5Uzk0SVFyTTJ1YSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1775310187);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `approval_histories`
--
ALTER TABLE `approval_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `approval_histories_pending_table_pending_id_index` (`pending_table`,`pending_id`);

--
-- Chỉ mục cho bảng `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `equipment_categories`
--
ALTER TABLE `equipment_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_categories_list_id_foreign` (`list_id`);

--
-- Chỉ mục cho bảng `equipment_items`
--
ALTER TABLE `equipment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_items_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `equipment_lists`
--
ALTER TABLE `equipment_lists`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_resets_admin`
--
ALTER TABLE `password_resets_admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `pending_equipment_categories`
--
ALTER TABLE `pending_equipment_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `pending_equipment_items`
--
ALTER TABLE `pending_equipment_items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `pending_equipment_lists`
--
ALTER TABLE `pending_equipment_lists`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `points_code_unique` (`code`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `approval_histories`
--
ALTER TABLE `approval_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `equipment_categories`
--
ALTER TABLE `equipment_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `equipment_items`
--
ALTER TABLE `equipment_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `equipment_lists`
--
ALTER TABLE `equipment_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `password_resets_admin`
--
ALTER TABLE `password_resets_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `pending_equipment_categories`
--
ALTER TABLE `pending_equipment_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `pending_equipment_items`
--
ALTER TABLE `pending_equipment_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `pending_equipment_lists`
--
ALTER TABLE `pending_equipment_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `points`
--
ALTER TABLE `points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `equipment_categories`
--
ALTER TABLE `equipment_categories`
  ADD CONSTRAINT `equipment_categories_list_id_foreign` FOREIGN KEY (`list_id`) REFERENCES `equipment_lists` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `equipment_items`
--
ALTER TABLE `equipment_items`
  ADD CONSTRAINT `equipment_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `equipment_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
