-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 21, 2026 lúc 04:29 PM
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
(1, 'đường sắt', '123123', 'duongsat@gmail.com', 'duongsat', 0, 1, 3, 1),
(3, 'demo', '321321', 'demo@gmail.com', 'demo', 3, 1, 2, 1);

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
(1, 'Xí Nghiệp Thuận Hải', '2026-03-21 10:25:03', '2026-03-21 10:25:03');

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
(3, 1, 'Cung Tháp Chàm', '2026-03-21 10:25:43', '2026-03-21 10:25:43');

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
(1, '2026_03_18_002025_create_sessions_table', 1),
(2, '2026_03_18_002344_create_password_resets_admin_table', 2);

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
('3aryIx1IEHO7NMzGKN1UUSNXL7iC6Zk1Qta15E1n', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiRGRjZjFYZlN5T3l4S3ZHaERSZUZocUpRN2FXdzA5RVhYR3l0b0FNaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774103784),
('639Bap6yUH5bJrxz6bzjDSgiN1nuFJIpX7YTOD3f', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToxNTp7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IjJhS0lESnI1bElGUDNUY0tUQ0haTFFDdzhId3FudjF1MXdVN2w4ZVUiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI4OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW5zIjtzOjU6InJvdXRlIjtzOjEyOiJhZG1pbnMuaW5kZXgiO31zOjc6InVzZXJfaWQiO2k6MTtzOjg6InVzZXJuYW1lIjtzOjE1OiLEkcaw4budbmcgc+G6r3QiO3M6ODoiZnVsbG5hbWUiO3M6ODoiZHVvbmdzYXQiO3M6NToiZW1haWwiO3M6MTg6ImR1b25nc2F0QGdtYWlsLmNvbSI7czo3OiJyb2xlX2lkIjtpOjA7czo5OiJicmFuY2hfaWQiO2k6MTtzOjc6ImRlcHRfaWQiO2k6MztzOjk6ImxvZ2dlZF9pbiI7YjoxO3M6NzoidXNlcl9pcCI7czo5OiIxMjcuMC4wLjEiO3M6MTA6InVzZXJfYWdlbnQiO3M6MTExOiJNb3ppbGxhLzUuMCAoV2luZG93cyBOVCAxMC4wOyBXaW42NDsgeDY0KSBBcHBsZVdlYktpdC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBDaHJvbWUvMTQ2LjAuMC4wIFNhZmFyaS81MzcuMzYiO3M6NzoiY3JlYXRlZCI7aToxNzc0MTA0MzQzO3M6MTM6Imxhc3RfYWN0aXZpdHkiO2k6MTc3NDEwNDM0Mzt9', 1774104364),
('cmvviIQ0YieneRo5CRx2rh2I645uP7gx4FdyxtLX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToxNjp7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6Ikh5Z2R5aDY4ZXVGdnBocTdKUGExU01Ccmk3Vm1yMVJXdDB5eElhckYiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vcGFzc3dvcmQtcmVxdWVzdHMiO3M6NToicm91dGUiO3M6MjM6InBhc3N3b3JkLXJlcXVlc3RzLmluZGV4Ijt9czo3OiJ1c2VyX2lkIjtpOjE7czo4OiJ1c2VybmFtZSI7czoxNToixJHGsOG7nW5nIHPhuq90IjtzOjg6ImZ1bGxuYW1lIjtzOjg6ImR1b25nc2F0IjtzOjU6ImVtYWlsIjtzOjE4OiJkdW9uZ3NhdEBnbWFpbC5jb20iO3M6Nzoicm9sZV9pZCI7aTowO3M6OToiYnJhbmNoX2lkIjtpOjE7czo3OiJkZXB0X2lkIjtpOjM7czo5OiJsb2dnZWRfaW4iO2I6MTtzOjc6InVzZXJfaXAiO3M6OToiMTI3LjAuMC4xIjtzOjEwOiJ1c2VyX2FnZW50IjtzOjExMToiTW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzE0Ni4wLjAuMCBTYWZhcmkvNTM3LjM2IjtzOjc6ImNyZWF0ZWQiO2k6MTc3NDEwMzMwMDtzOjEzOiJsYXN0X2FjdGl2aXR5IjtpOjE3NzQxMDMzMDA7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3Bhc3N3b3JkLXJlcXVlc3RzIjt9fQ==', 1774104389),
('GIsGE44TIUfZ4xs9zj1EhtVDu3hDW87bL6cRjhJk', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoibkhGVjh3Q3ZBNkxXSHF3endXbHNaUldGNG56RmloVnBtZldTYkNYViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774101539),
('GTZdtj05lbLqgpZt9syJWHL1FE4huOLe0Cb9maVg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToxNjp7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IkoxNUM4NGMzS2pEaUlXczdsOEJyaFI4Z2NxeFNPYVpmcEJNcDVmaDUiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFuZy1uaGFwIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo3OiJ1c2VyX2lkIjtpOjE7czo4OiJ1c2VybmFtZSI7czoxNToixJHGsOG7nW5nIHPhuq90IjtzOjg6ImZ1bGxuYW1lIjtOO3M6NToiZW1haWwiO3M6MTg6ImR1b25nc2F0QGdtYWlsLmNvbSI7czo3OiJyb2xlX2lkIjtpOjE7czo5OiJicmFuY2hfaWQiO2k6MDtzOjc6ImRlcHRfaWQiO2k6MDtzOjk6ImxvZ2dlZF9pbiI7YjoxO3M6NzoidXNlcl9pcCI7czo5OiIxMjcuMC4wLjEiO3M6MTA6InVzZXJfYWdlbnQiO3M6MTExOiJNb3ppbGxhLzUuMCAoV2luZG93cyBOVCAxMC4wOyBXaW42NDsgeDY0KSBBcHBsZVdlYktpdC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBDaHJvbWUvMTQ2LjAuMC4wIFNhZmFyaS81MzcuMzYiO3M6NzoiY3JlYXRlZCI7aToxNzc0MTAxNTQ2O3M6MTM6Imxhc3RfYWN0aXZpdHkiO2k6MTc3NDEwMTU0NjtzOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vcGFzc3dvcmQtcmVxdWVzdHMiO319', 1774101547),
('gzpnQgTTo6dSl27xN2eRSBgSDFig6CkvKfdIaayA', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoibGpFaWpTc0ZzQVZDbEU3VndPZ2FodEdoZTlHWk1Ma3ZoMmhPczR0eiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774101510),
('ILlopCWXYmO7kbt7brLjKeZPY1zY4kuCbR4WoOzg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiQ25kMXk5U0thRWtienpXaG1STzZpOTE2bnZGbUNvSW5XUjhoRVg4ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774103711),
('InJQgBUWEROBm1WZ5DBKySj33xWsiRjh0gpHiU7h', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToxNjp7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IkhGYUNJaGN3alF4d0VqZE1TMGxNa1JEN2s1VndGVXlGTGJyY2FkWHMiO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFuZy1uaGFwIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo3OiJ1c2VyX2lkIjtpOjE7czo4OiJ1c2VybmFtZSI7czoxNToixJHGsOG7nW5nIHPhuq90IjtzOjg6ImZ1bGxuYW1lIjtOO3M6NToiZW1haWwiO3M6MTg6ImR1b25nc2F0QGdtYWlsLmNvbSI7czo3OiJyb2xlX2lkIjtpOjA7czo5OiJicmFuY2hfaWQiO2k6MTtzOjc6ImRlcHRfaWQiO2k6MztzOjk6ImxvZ2dlZF9pbiI7YjoxO3M6NzoidXNlcl9pcCI7czo5OiIxMjcuMC4wLjEiO3M6MTA6InVzZXJfYWdlbnQiO3M6MTExOiJNb3ppbGxhLzUuMCAoV2luZG93cyBOVCAxMC4wOyBXaW42NDsgeDY0KSBBcHBsZVdlYktpdC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBDaHJvbWUvMTQ2LjAuMC4wIFNhZmFyaS81MzcuMzYiO3M6NzoiY3JlYXRlZCI7aToxNzc0MTAxNjA2O3M6MTM6Imxhc3RfYWN0aXZpdHkiO2k6MTc3NDEwMTYwNjtzOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vcGFzc3dvcmQtcmVxdWVzdHMiO319', 1774101636),
('joCwdjWkrgBCgQ0lpNc8eup6PWQxzjIrp5EoufuG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToxNjp7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IlhCM1BWOTNleWFrdmFiQUZFMGRQaEgyNVozNzBPN1g3eXBCaGNOOTciO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFuZy1uaGFwIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo3OiJ1c2VyX2lkIjtpOjE7czo4OiJ1c2VybmFtZSI7czoxNToixJHGsOG7nW5nIHPhuq90IjtzOjg6ImZ1bGxuYW1lIjtOO3M6NToiZW1haWwiO3M6MTg6ImR1b25nc2F0QGdtYWlsLmNvbSI7czo3OiJyb2xlX2lkIjtpOjA7czo5OiJicmFuY2hfaWQiO2k6MTtzOjc6ImRlcHRfaWQiO2k6MztzOjk6ImxvZ2dlZF9pbiI7YjoxO3M6NzoidXNlcl9pcCI7czo5OiIxMjcuMC4wLjEiO3M6MTA6InVzZXJfYWdlbnQiO3M6MTExOiJNb3ppbGxhLzUuMCAoV2luZG93cyBOVCAxMC4wOyBXaW42NDsgeDY0KSBBcHBsZVdlYktpdC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBDaHJvbWUvMTQ2LjAuMC4wIFNhZmFyaS81MzcuMzYiO3M6NzoiY3JlYXRlZCI7aToxNzc0MTAyODY3O3M6MTM6Imxhc3RfYWN0aXZpdHkiO2k6MTc3NDEwMjg2NztzOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vcGFzc3dvcmQtcmVxdWVzdHMiO319', 1774103291),
('NdCAOsMl1f6roqPPgC19gFd8WCAc8X4R0eCpnWFl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiVlUzOHVvWmRvS29mZUZuaFR4Njl2WG16V1YyWnJPTjhndUc2QkFBMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774104307),
('nhFpgtok17tUESrhX7hGfDRIdcMG5Vugmq2Ogpzs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiakVsS0ZSNUJxbUdkbG82ZnVaZkt4OTVoYjZzYlM0ZWJxTGRPeTYxeCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774101518),
('O3wLUAknv0gfxWfDuKKNLAeqSAuVaPjsiYp7RhEK', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToxNjp7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IlhxOHVqOG1VcVM2d2E4TW0wVVZRN3JzazlqRGMwU1JNcTdUZ3lBV3ciO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFuZy1uaGFwIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo3OiJ1c2VyX2lkIjtpOjE7czo4OiJ1c2VybmFtZSI7czoxNToixJHGsOG7nW5nIHPhuq90IjtzOjg6ImZ1bGxuYW1lIjtOO3M6NToiZW1haWwiO3M6MTg6ImR1b25nc2F0QGdtYWlsLmNvbSI7czo3OiJyb2xlX2lkIjtpOjA7czo5OiJicmFuY2hfaWQiO2k6MTtzOjc6ImRlcHRfaWQiO2k6MztzOjk6ImxvZ2dlZF9pbiI7YjoxO3M6NzoidXNlcl9pcCI7czo5OiIxMjcuMC4wLjEiO3M6MTA6InVzZXJfYWdlbnQiO3M6MTExOiJNb3ppbGxhLzUuMCAoV2luZG93cyBOVCAxMC4wOyBXaW42NDsgeDY0KSBBcHBsZVdlYktpdC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBDaHJvbWUvMTQ2LjAuMC4wIFNhZmFyaS81MzcuMzYiO3M6NzoiY3JlYXRlZCI7aToxNzc0MTAxNjQ2O3M6MTM6Imxhc3RfYWN0aXZpdHkiO2k6MTc3NDEwMTY0NjtzOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vcGFzc3dvcmQtcmVxdWVzdHMiO319', 1774102859),
('PmlpO4wTKQsYXp0nDnZRARpjtJT56x2cwJ4kA3yg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoibFRkd1JORWtickxnYjVKYkJ3clZGUHFxU2RlYTM3eVJvVVI1ZHN4aSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1774101601),
('tB7U8raq8GFfPrhXCCdhjEftlFsyipAzrAsXM3BZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGd1STRjVzNZTERBblpNTXVEMEZEaW9icmFRSUl0N3d2dzM3MWhIMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYW5nLW5oYXAiO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774101427);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
