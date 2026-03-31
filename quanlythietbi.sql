-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 31, 2026 lúc 06:38 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

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
(1, 'đường sắt', '123123', 'duongsat@gmail.com', 'duongsat', 2, 1, 3, 1),
(3, 'demo', '321321', 'demo@gmail.com', 'demo', 2, 1, 3, 1),
(5, 'admin', '123456', 'admin@test.com', 'Administrator', 0, 1, 1, 1);

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
(6, 3, 'Sài Gòn', '2026-03-31 16:11:33', '2026-03-31 16:11:33');

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
(3, 'Thiết bị B', 6, 3, 1, '2026-03-31 04:30:52', '2026-03-31 15:43:10'),
(4, 'Thiết bị A', 6, 3, 1, '2026-03-31 15:42:57', '2026-03-31 15:42:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `equipment_items`
--

CREATE TABLE `equipment_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
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

INSERT INTO `equipment_items` (`id`, `name`, `code`, `category_id`, `point_id`, `material`, `unit`, `quantity`, `manufacture_year`, `expiry_date`, `condition`, `note`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Thiết bị 01', '001', 4, 3, 'abc', 'cái', 1, 2025, '2026-03-12', 1, NULL, 1, '2026-03-31 15:43:40', '2026-03-31 15:43:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `equipment_lists`
--

CREATE TABLE `equipment_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `point_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1: Hoạt động, 0: Vô hiệu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `equipment_lists`
--

INSERT INTO `equipment_lists` (`id`, `point_id`, `name`, `code`, `description`, `status`, `created_at`, `updated_at`) VALUES
(5, 2, 'Thiết bị truyền dẫn', '001', 'abc', 1, '2026-03-31 04:02:45', '2026-03-31 04:02:45'),
(6, 3, 'Thiết bị SDH', '002', NULL, 1, '2026-03-31 04:04:22', '2026-03-31 04:04:22'),
(7, 4, 'Thiết bị truyền dẫn', '004', NULL, 1, '2026-03-31 16:13:45', '2026-03-31 16:13:45');

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
(12, '2026_03_31_111517_add_point_id_to_equipment_categories_table', 7);

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

--
-- Đang đổ dữ liệu cho bảng `password_reset_requests`
--

INSERT INTO `password_reset_requests` (`id`, `email`, `full_name`, `status`, `requested_at`, `processed_at`, `processed_by`, `created_at`, `updated_at`) VALUES
(1, 'demo@gmail.com', 'demo', 1, '2026-03-21 13:58:56', '2026-03-21 14:34:52', NULL, '2026-03-21 13:58:56', '2026-03-21 14:34:52');

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
(2, 'TTTH Phước Nhơn', '002', 3, 1, 1, '2026-03-30 18:00:19', '2026-03-31 15:37:07'),
(3, 'TTTH Kà Rôm', '001', 3, 1, 1, '2026-03-31 04:03:46', '2026-03-31 15:36:58'),
(4, 'Sóng Thần', '003', 6, 1, 1, '2026-03-31 16:11:56', '2026-03-31 16:11:56');

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
('4VpnYGIepTQhMCUV9jIMzQrIxDh4j9OhbSz6Xkdl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToxNTp7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IkxyN2RRcHVUM2hId0pKcXBtQVY4ZFJKYXVrNWZ1TWs3WXRkVFQ3QTEiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZXF1aXBtZW50LWl0ZW1zIjtzOjU6InJvdXRlIjtzOjIxOiJlcXVpcG1lbnQtaXRlbXMuaW5kZXgiO31zOjc6InVzZXJfaWQiO2k6NTtzOjg6InVzZXJuYW1lIjtzOjU6ImFkbWluIjtzOjg6ImZ1bGxuYW1lIjtzOjEzOiJBZG1pbmlzdHJhdG9yIjtzOjU6ImVtYWlsIjtzOjE0OiJhZG1pbkB0ZXN0LmNvbSI7czo3OiJyb2xlX2lkIjtpOjA7czo5OiJicmFuY2hfaWQiO2k6MTtzOjc6ImRlcHRfaWQiO2k6MTtzOjk6ImxvZ2dlZF9pbiI7YjoxO3M6NzoidXNlcl9pcCI7czo5OiIxMjcuMC4wLjEiO3M6MTA6InVzZXJfYWdlbnQiO3M6MTExOiJNb3ppbGxhLzUuMCAoV2luZG93cyBOVCAxMC4wOyBXaW42NDsgeDY0KSBBcHBsZVdlYktpdC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBDaHJvbWUvMTQ2LjAuMC4wIFNhZmFyaS81MzcuMzYiO3M6NzoiY3JlYXRlZCI7aToxNzc0OTczNzAwO3M6MTM6Imxhc3RfYWN0aXZpdHkiO2k6MTc3NDk3MzcwMDt9', 1774974060),
('61HU4olnCIzzcRo24GjkL5330TIXIYtLiopOr5Td', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGhQU2VlWTRzbGFLQXZkYUN4VVdvT0o4dmJRa1ZOV3ZwRWRFSm9qdiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774971321),
('Gr1CLhlWrqQiaiWzD6kKbcDxHSTQ35Nk4vJhSUUq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoidW1kUnVuSkIycHh5NWxTMXczTGN3dTB5TWR3NEJTODh0aVhwaHZqTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774973674),
('jYtd3ignDTGUcacyj3trnMwwmnO9LyEhbnItgHl7', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiZ0NGanNVc0YweGFFVlltRjNuckdlUzFzQm1DWkJQMGpqcncwNVlSMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774973639),
('t7IYlrmKyzGbYerFvREZgKyEDa2xJ4TzGWkBZdZv', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiTmZ4NHhJaEZPcWc0ZWMwUllhdXhVenFlZzRGNlRZZVg5eGNBaklFeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774973696);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `equipment_items_code_unique` (`code`),
  ADD KEY `equipment_items_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `equipment_lists`
--
ALTER TABLE `equipment_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipment_lists_code_unique` (`code`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `equipment_items`
--
ALTER TABLE `equipment_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `equipment_lists`
--
ALTER TABLE `equipment_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `password_resets_admin`
--
ALTER TABLE `password_resets_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `password_reset_requests`
--
ALTER TABLE `password_reset_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `points`
--
ALTER TABLE `points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
