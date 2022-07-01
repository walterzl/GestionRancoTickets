USE [master]
GO
/****** Object:  Database [GESTION]    Script Date: 26-04-2021 11:50:04 ******/
CREATE DATABASE [GESTION]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'GESTION', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\GESTION.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'GESTION_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.MSSQLSERVER\MSSQL\DATA\GESTION_log.LDF' , SIZE = 8512KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO
ALTER DATABASE [GESTION] SET COMPATIBILITY_LEVEL = 100
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [GESTION].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [GESTION] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [GESTION] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [GESTION] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [GESTION] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [GESTION] SET ARITHABORT OFF 
GO
ALTER DATABASE [GESTION] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [GESTION] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [GESTION] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [GESTION] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [GESTION] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [GESTION] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [GESTION] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [GESTION] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [GESTION] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [GESTION] SET  DISABLE_BROKER 
GO
ALTER DATABASE [GESTION] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [GESTION] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [GESTION] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [GESTION] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [GESTION] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [GESTION] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [GESTION] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [GESTION] SET RECOVERY FULL 
GO
ALTER DATABASE [GESTION] SET  MULTI_USER 
GO
ALTER DATABASE [GESTION] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [GESTION] SET DB_CHAINING OFF 
GO
ALTER DATABASE [GESTION] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [GESTION] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
ALTER DATABASE [GESTION] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [GESTION] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
EXEC sys.sp_db_vardecimal_storage_format N'GESTION', N'ON'
GO
ALTER DATABASE [GESTION] SET QUERY_STORE = OFF
GO
USE [GESTION]
GO
/****** Object:  Table [dbo].[td_documento]    Script Date: 26-04-2021 11:50:05 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[td_documento](
	[doc_id] [int] IDENTITY(1,1) NOT NULL,
	[tick_id] [int] NULL,
	[doc_nom] [varchar](500) NULL,
	[fech_crea] [datetime] NULL,
	[est] [int] NULL,
 CONSTRAINT [PK_td_documento] PRIMARY KEY CLUSTERED 
(
	[doc_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[td_ticketdetalle]    Script Date: 26-04-2021 11:50:05 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[td_ticketdetalle](
	[tickd_id] [int] IDENTITY(1,1) NOT NULL,
	[tick_id] [int] NULL,
	[usu_id] [int] NULL,
	[tickd_descrip] [varchar](max) NULL,
	[fech_crea] [datetime] NULL,
	[est] [int] NULL,
 CONSTRAINT [PK_td_ticketdetalle] PRIMARY KEY CLUSTERED 
(
	[tickd_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tm_area]    Script Date: 26-04-2021 11:50:05 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tm_area](
	[area_id] [int] IDENTITY(1,1) NOT NULL,
	[area_nom] [varchar](150) NULL,
	[fech_crea] [datetime] NULL,
	[est] [int] NULL,
 CONSTRAINT [PK_tm_area] PRIMARY KEY CLUSTERED 
(
	[area_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tm_categoria]    Script Date: 26-04-2021 11:50:05 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tm_categoria](
	[cat_id] [int] IDENTITY(1,1) NOT NULL,
	[grupo_id] [int] NULL,
	[tip_id] [int] NULL,
	[cat_nom] [varchar](150) NULL,
	[fech_crea] [datetime] NULL,
	[est] [int] NOT NULL,
 CONSTRAINT [PK_tm_categoria] PRIMARY KEY CLUSTERED 
(
	[cat_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tm_grupo_usuario]    Script Date: 26-04-2021 11:50:05 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tm_grupo_usuario](
	[grupo_id] [int] IDENTITY(1,1) NOT NULL,
	[grupo_nom] [varchar](500) NULL,
	[fech_crea] [datetime] NULL,
	[est] [int] NULL,
 CONSTRAINT [PK_tm_grupo_usuario] PRIMARY KEY CLUSTERED 
(
	[grupo_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tm_subarea]    Script Date: 26-04-2021 11:50:05 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tm_subarea](
	[suba_id] [int] IDENTITY(1,1) NOT NULL,
	[area_id] [int] NULL,
	[suba_nom] [varchar](150) NULL,
	[fech_crea] [datetime] NULL,
	[est] [int] NULL,
 CONSTRAINT [PK_tm_subarea] PRIMARY KEY CLUSTERED 
(
	[suba_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tm_ticket]    Script Date: 26-04-2021 11:50:05 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tm_ticket](
	[tick_id] [int] IDENTITY(1,1) NOT NULL,
	[usu_id] [int] NULL,
	[cat_id] [int] NULL,
	[tick_titulo] [varchar](150) NULL,
	[tick_descrip] [varchar](max) NULL,
	[tick_estado] [varchar](50) NULL,
	[tick_prio] [varchar](50) NULL,
	[area_id] [int] NULL,
	[usu_asig] [int] NULL,
	[suba_id] [int] NULL,
	[fech_cierre] [datetime] NULL,
	[fech_crea] [datetime] NULL,
	[fech_asig] [datetime] NULL,
	[tip_id] [int] NULL,
	[est] [int] NULL,
 CONSTRAINT [PK_tm_ticket] PRIMARY KEY CLUSTERED 
(
	[tick_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tm_usuario]    Script Date: 26-04-2021 11:50:05 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tm_usuario](
	[usu_id] [int] IDENTITY(1,1) NOT NULL,
	[usu_nom] [varchar](150) NULL,
	[usu_ape] [varchar](150) NULL,
	[usu_correo] [varchar](250) NULL,
	[usu_pass] [varchar](50) NULL,
	[rol_id] [int] NULL,
	[grupo_id] [int] NULL,
	[area_id] [int] NULL,
	[suba_id] [int] NULL,
	[fech_crea] [datetime] NULL,
	[fech_modi] [datetime] NULL,
	[fech_elim] [datetime] NULL,
	[est] [int] NULL,
 CONSTRAINT [PK_tm_usuario] PRIMARY KEY CLUSTERED 
(
	[usu_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [dbo].[td_documento] ON 

INSERT [dbo].[td_documento] ([doc_id], [tick_id], [doc_nom], [fech_crea], [est]) VALUES (13, 13, N'cfg yt.xml', CAST(N'2021-04-16T18:05:52.687' AS DateTime), 1)
SET IDENTITY_INSERT [dbo].[td_documento] OFF
GO
SET IDENTITY_INSERT [dbo].[tm_area] ON 

INSERT [dbo].[tm_area] ([area_id], [area_nom], [fech_crea], [est]) VALUES (1, N'Administración', CAST(N'2021-04-06T09:40:33.597' AS DateTime), 1)
INSERT [dbo].[tm_area] ([area_id], [area_nom], [fech_crea], [est]) VALUES (2, N'Agricola', CAST(N'2021-04-06T09:40:41.440' AS DateTime), 1)
INSERT [dbo].[tm_area] ([area_id], [area_nom], [fech_crea], [est]) VALUES (3, N'Gerencia General', CAST(N'2021-04-06T09:40:46.080' AS DateTime), 1)
INSERT [dbo].[tm_area] ([area_id], [area_nom], [fech_crea], [est]) VALUES (4, N'TESt2', CAST(N'2021-04-06T09:40:51.040' AS DateTime), 0)
INSERT [dbo].[tm_area] ([area_id], [area_nom], [fech_crea], [est]) VALUES (5, N'Calidad y Desarrollo', CAST(N'2021-04-14T00:00:00.000' AS DateTime), 1)
INSERT [dbo].[tm_area] ([area_id], [area_nom], [fech_crea], [est]) VALUES (6, N'Exportaciones', CAST(N'2021-04-16T17:13:14.613' AS DateTime), 1)
INSERT [dbo].[tm_area] ([area_id], [area_nom], [fech_crea], [est]) VALUES (7, N'Planta', CAST(N'2021-04-16T17:14:13.913' AS DateTime), 1)
INSERT [dbo].[tm_area] ([area_id], [area_nom], [fech_crea], [est]) VALUES (8, N'Productores', CAST(N'2021-04-16T17:14:25.413' AS DateTime), 1)
SET IDENTITY_INSERT [dbo].[tm_area] OFF
GO
SET IDENTITY_INSERT [dbo].[tm_categoria] ON 

INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (9, 1, 1, N'Error de Equipo', CAST(N'2021-04-16T17:45:25.883' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (10, 1, 1, N'Error de Software', CAST(N'2021-04-16T17:47:25.040' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (11, 1, 1, N'Instalación y actualización Programas', CAST(N'2021-04-16T17:47:41.027' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (12, 3, 4, N'Mantenimiento 1', CAST(N'2021-04-16T17:49:52.127' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (13, 2, 3, N'Nueva función SDT', CAST(N'2021-04-16T17:52:26.787' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (14, 2, 3, N'Nuevo Desarrollo', CAST(N'2021-04-16T17:53:58.703' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (15, 2, 3, N'Funcionalidad Unitec', CAST(N'2021-04-16T17:58:26.833' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (16, 2, 3, N'Funcionalidad IPLA', CAST(N'2021-04-16T17:58:43.827' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (17, 2, 3, N'Gespack, Portal Clientes y Productores', CAST(N'2021-04-16T17:58:56.737' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (18, 2, 3, N'Portal Ingreso de Camiones', CAST(N'2021-04-16T18:01:23.520' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (19, 2, 3, N'Sharepoint', CAST(N'2021-04-16T18:01:50.463' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (20, 2, 3, N'Datawarehouse', CAST(N'2021-04-16T18:02:00.620' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (21, 2, 3, N'Reporte Power BI', CAST(N'2021-04-16T18:02:21.763' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (22, 2, 3, N'Sistema Ticket', CAST(N'2021-04-16T18:02:48.250' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (23, 1, 2, N'Frio Packing', CAST(N'2021-04-16T18:03:11.297' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (24, 1, 2, N'Contabilidad', CAST(N'2021-04-16T18:03:52.523' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (25, 1, 2, N'Tesoreria', CAST(N'2021-04-16T18:04:09.853' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (26, 1, 2, N'Cuentas corrientes', CAST(N'2021-04-16T18:04:23.243' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (27, 1, 2, N'Estimaciones productivas', CAST(N'2021-04-16T18:04:45.407' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (28, 2, 3, N'eeee', CAST(N'2021-04-16T18:09:02.767' AS DateTime), 1)
INSERT [dbo].[tm_categoria] ([cat_id], [grupo_id], [tip_id], [cat_nom], [fech_crea], [est]) VALUES (29, 1, 2, N'eeeeeeex', CAST(N'2021-04-16T18:11:40.820' AS DateTime), 1)
SET IDENTITY_INSERT [dbo].[tm_categoria] OFF
GO
SET IDENTITY_INSERT [dbo].[tm_grupo_usuario] ON 

INSERT [dbo].[tm_grupo_usuario] ([grupo_id], [grupo_nom], [fech_crea], [est]) VALUES (1, N'Soporte TI', NULL, 1)
INSERT [dbo].[tm_grupo_usuario] ([grupo_id], [grupo_nom], [fech_crea], [est]) VALUES (2, N'Desarrollo', NULL, 1)
INSERT [dbo].[tm_grupo_usuario] ([grupo_id], [grupo_nom], [fech_crea], [est]) VALUES (3, N'Mantenimiento', NULL, 1)
INSERT [dbo].[tm_grupo_usuario] ([grupo_id], [grupo_nom], [fech_crea], [est]) VALUES (4, N'Usuario Común', CAST(N'2021-04-16T19:37:48.817' AS DateTime), 1)
SET IDENTITY_INSERT [dbo].[tm_grupo_usuario] OFF
GO
SET IDENTITY_INSERT [dbo].[tm_subarea] ON 

INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (1, 1, N'Personas', CAST(N'2021-04-06T09:42:29.667' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (2, 3, N'La Union', CAST(N'2021-04-06T09:42:37.603' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (3, 2, N'General', CAST(N'2021-04-06T09:42:48.410' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (4, 2, N'a', CAST(N'2021-04-06T09:43:49.367' AS DateTime), 0)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (5, 1, N'General', CAST(N'2021-04-16T17:14:55.170' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (6, 1, N'TI', CAST(N'2021-04-16T17:15:22.757' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (7, 2, N'La Unión', CAST(N'2021-04-16T17:15:51.850' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (8, 2, N'Los Tachos', CAST(N'2021-04-16T17:16:02.620' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (9, 5, N'Aseguramiento Integrado', CAST(N'2021-04-16T17:16:17.153' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (10, 5, N'General', CAST(N'2021-04-16T17:16:27.687' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (11, 5, N'I+I+D', CAST(N'2021-04-16T17:16:49.213' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (12, 6, N'COMEX', CAST(N'2021-04-16T17:17:13.707' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (13, 6, N'General', CAST(N'2021-04-16T17:17:30.913' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (14, 6, N'Logística', CAST(N'2021-04-16T17:17:44.740' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (15, 6, N'Planificación Comercial', CAST(N'2021-04-16T17:18:01.300' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (16, 3, N'General', CAST(N'2021-04-16T17:18:36.230' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (17, 7, N'Bodega y Patio', CAST(N'2021-04-16T17:18:49.840' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (18, 7, N'Frio', CAST(N'2021-04-16T17:19:07.787' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (19, 7, N'General', CAST(N'2021-04-16T17:19:14.007' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (20, 7, N'Mantención ', CAST(N'2021-04-16T17:19:34.383' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (21, 7, N'Recepción ', CAST(N'2021-04-16T17:19:44.533' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (22, 7, N'SAG', CAST(N'2021-04-16T17:19:57.330' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (23, 7, N'Packing', CAST(N'2021-04-16T17:20:31.970' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (24, 8, N'Centro Acopio La Unión', CAST(N'2021-04-16T17:21:22.790' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (25, 8, N'CORFO 17PDP-84189', CAST(N'2021-04-16T17:21:37.150' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (26, 8, N'General', CAST(N'2021-04-16T17:21:46.623' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (27, 8, N'IX Región', CAST(N'2021-04-16T17:21:58.183' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (28, 8, N'X Región', CAST(N'2021-04-16T17:22:09.660' AS DateTime), 1)
INSERT [dbo].[tm_subarea] ([suba_id], [area_id], [suba_nom], [fech_crea], [est]) VALUES (29, 5, N'Calidad', CAST(N'2021-04-26T10:54:24.447' AS DateTime), 1)
SET IDENTITY_INSERT [dbo].[tm_subarea] OFF
GO
SET IDENTITY_INSERT [dbo].[tm_ticket] ON 

INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (13, 3, 24, N'prueba1 ', N'<p>prueba1&nbsp;<br></p>', N'Abierto', N'Baja', 1, 15, 5, NULL, CAST(N'2021-04-16T18:05:52.683' AS DateTime), CAST(N'2021-04-24T16:59:29.633' AS DateTime), 2, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (14, 3, 13, N'ccc', N'<p>cc</p>', N'Abierto', N'Media', 1, NULL, 1, NULL, CAST(N'2021-04-16T18:57:41.413' AS DateTime), NULL, 3, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (15, 3, 24, N'm', N'<p>aa</p>', N'Abierto', N'Media', 1, NULL, 1, NULL, CAST(N'2021-04-16T19:01:53.440' AS DateTime), NULL, 2, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (16, 3, 12, N'ddd', N'<p>dd</p>', N'Abierto', N'Media', 1, NULL, 5, NULL, CAST(N'2021-04-16T19:05:46.113' AS DateTime), NULL, 4, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (17, 3, 23, N'ingreso prueba error', N'<p>ingreso prueba error<br></p>', N'Abierto', N'Alta', 1, NULL, 1, NULL, CAST(N'2021-04-16T19:18:11.477' AS DateTime), NULL, 2, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (18, 3, 9, N'q', N'<p>q</p>', N'Abierto', N'Baja', 1, NULL, 1, NULL, CAST(N'2021-04-16T19:58:40.463' AS DateTime), NULL, 1, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (19, 3, 24, N'prueba 2005', N'<p>prueba 2005<br></p>', N'Abierto', N'Media', 1, NULL, 5, NULL, CAST(N'2021-04-16T20:05:44.317' AS DateTime), NULL, 2, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (20, 3, 24, N'ss', N'<p>sss</p>', N'Abierto', N'Baja', 1, NULL, 1, NULL, CAST(N'2021-04-16T20:11:20.617' AS DateTime), NULL, 2, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (21, 15, 12, N'nuevo ticket sin archivo', N'<p>nuevo ticket sin archivo<br></p>', N'Abierto', N'Alta', 1, NULL, 6, NULL, CAST(N'2021-04-19T15:18:05.807' AS DateTime), NULL, 4, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (22, 15, 22, N'arreglo de ingreso tickets', N'<p>arreglo de ingreso tickets<br></p>', N'Abierto', N'Media', 1, NULL, 6, NULL, CAST(N'2021-04-19T17:32:24.477' AS DateTime), NULL, 3, 1)
INSERT [dbo].[tm_ticket] ([tick_id], [usu_id], [cat_id], [tick_titulo], [tick_descrip], [tick_estado], [tick_prio], [area_id], [usu_asig], [suba_id], [fech_cierre], [fech_crea], [fech_asig], [tip_id], [est]) VALUES (23, 15, 23, N'prueba correo 24-04 walter', N'<p>prueba correo 24-04 walter<br></p>', N'Abierto', N'Alta', 1, NULL, 6, NULL, CAST(N'2021-04-24T16:55:50.010' AS DateTime), NULL, 2, 1)
SET IDENTITY_INSERT [dbo].[tm_ticket] OFF
GO
SET IDENTITY_INSERT [dbo].[tm_usuario] ON 

INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (1, N'Guillermo', N'Silva', N'gsilva@ranco.cl', N'123456', 2, 1, 1, 6, NULL, NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (2, N'root', N'root', N'wzuniga@ranco.cl', N'1234567', 3, 1, 3, 16, NULL, NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (3, N'Soporte', N'TI', N'soporteti@ranco.com', N'1234567', 3, 2, 1, 1, CAST(N'2021-04-06T09:39:28.617' AS DateTime), NULL, CAST(N'2021-04-06T09:40:03.863' AS DateTime), 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (4, N'test22', N'asdasd22', N'asasdas@asdasd.com2', N'123456', 1, 1, 1, 1, CAST(N'2021-04-09T15:28:16.223' AS DateTime), NULL, CAST(N'2021-04-09T15:28:55.750' AS DateTime), 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (5, N'yyy', N'yyy', N'xxx@xxxc.com', N'123456', 1, 1, 1, 1, CAST(N'2021-04-09T15:28:49.410' AS DateTime), NULL, CAST(N'2021-04-26T11:47:48.177' AS DateTime), 0)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (6, N'Coni', N'Zoto', N'walter.zunigalineros@gmail.com', N'123456', 1, 4, 2, 3, CAST(N'2021-04-14T13:00:24.593' AS DateTime), NULL, CAST(N'2021-04-26T11:43:17.253' AS DateTime), 0)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (7, N'Lenot', N'Comte', N'lcomte@ranco.cl', N'123456', 2, 1, 1, 6, CAST(N'2021-04-14T13:02:09.187' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (9, N'Leyla', N'Readi', N'lreadi@ranco.cl', N'123456', 2, 2, 1, 6, CAST(N'2021-04-14T13:03:00.680' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (10, N'test', N'test2', N'tes@asdasd.com', N'123456', 2, 1, 3, 0, CAST(N'2021-04-15T21:26:36.770' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (11, N'aaaa', N'aaa', N'aaaa@aaa.com', N'123456', 2, 2, 2, 0, CAST(N'2021-04-15T21:27:07.900' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (12, N'aaaaa', N'aaaaa', N'aaaaa@asdasd.com', N'123456', 1, 1, 3, 2, CAST(N'2021-04-15T21:28:45.440' AS DateTime), NULL, CAST(N'2021-04-15T21:28:56.590' AS DateTime), 0)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (13, N'Leandro', N'Droguette', N'ldroguett@ranco.cl', N'123456', 2, 2, 1, 6, CAST(N'2021-04-16T19:45:08.190' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (14, N'Aron', N'Alarcon', N'aalarcon@ranco.cl', N'123456', 2, 3, 7, 20, CAST(N'2021-04-16T19:46:00.730' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (15, N'Walter', N'Zuñiga', N'walterito133@gmail.com', N'123456', 2, 1, 1, 6, CAST(N'2021-04-16T19:47:00.330' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (16, N'Manuel', N'Ortega', N'mortega@ranco.cl', N'123456', 2, 1, 1, 6, CAST(N'2021-04-16T19:47:25.143' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (17, N'walter', N'Zuñiga', N'walterito133@gmail.com', N'123456', 2, 1, 1, 5, CAST(N'2021-04-16T19:48:02.803' AS DateTime), NULL, CAST(N'2021-04-26T11:40:04.397' AS DateTime), 0)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (18, N'Alberto ', N'Merino', N'ATERRENO@ranco.cl', N'123456', 1, 4, 2, 7, CAST(N'2021-04-20T11:37:35.937' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (19, N'Alejandra ', N'Concha', N'aconcha@ranco.cl', N'123456', 1, 4, 6, 12, CAST(N'2021-04-20T11:38:15.277' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (20, N'Alex ', N'Bravo', N'a.bravo@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T11:40:27.857' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (21, N'Alex ', N'Piñeda', N'apineda@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T11:41:04.983' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (22, N'Alfonso ', N'Castro', N'acastro@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T11:41:34.820' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (23, N'Andrea ', N'Lopez', N'alopez@ranco.cl', N'123456', 1, 4, 6, 12, CAST(N'2021-04-20T11:42:06.047' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (24, N'Andres', N'Illanes', N'aillanes@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T11:43:09.670' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (25, N'Angelica ', N'Henriquez', N'ahenriquez@ranco.cl', N'123456', 1, 4, 5, 29, CAST(N'2021-04-20T11:43:56.627' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (26, N'Barbara ', N'Quinchel', N'bquinchel@ranco.cl', N'123456', 1, 4, 2, 7, CAST(N'2021-04-20T11:45:33.470' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (27, N'Benjamin ', N'Mangelsdorff', N'bmangels@ranco.cl', N'123456', 1, 4, 8, 26, CAST(N'2021-04-20T11:46:03.460' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (28, N'Benjamin ', N'Saldias', N'bsaldias@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T11:46:39.993' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (29, N'Bianca ', N'Cornejo', N'bcornejo@ranco.cl', N'123456', 1, 4, 1, 1, CAST(N'2021-04-20T11:47:09.753' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (30, N'Bodega ', N'Norte', N'bodeganorte@ranco.cl', N'123456', 1, 4, 7, 17, CAST(N'2021-04-20T11:47:59.360' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (31, N'Carla ', N'Herrera', N'c.herrera@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T11:48:23.143' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (32, N'Carlos ', N'Gatica', N'cgatica@ranco.cl', N'123456', 1, 4, 2, 7, CAST(N'2021-04-20T11:48:54.800' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (33, N'Carlos ', N'Manriquez', N'cmanriquez@ranco.cl', N'123456', 1, 4, 2, 7, CAST(N'2021-04-20T11:49:33.387' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (34, N'Carolina ', N'Alcalde', N'calcalde@ranco.cl', N'123456', 1, 4, 6, 13, CAST(N'2021-04-20T11:50:04.110' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (35, N'Carolina ', N'Bustamante', N'secretaria@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T11:50:36.370' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (36, N'Carolina ', N'Clavijo', N'cclavijo@ranco.cl', N'123456', 1, 4, 5, 11, CAST(N'2021-04-20T11:51:19.370' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (37, N'carolina horta', N'horta', N'chorta@ranco.cl', N'123456', 1, 4, 1, 1, CAST(N'2021-04-20T11:52:48.703' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (38, N'Carolina ', N'Tagle', N'ctagle@ranco.cl', N'123456', 1, 4, 5, 29, CAST(N'2021-04-20T11:53:27.723' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (39, N'Casandra ', N'Maturana', N'cmaturana@ranco.cl', N'123456', 1, 4, 5, 29, CAST(N'2021-04-20T11:54:16.097' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (40, N'Cesar ', N'Gonzalez', N'cgonzalez@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T11:54:56.443' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (41, N'Claudia ', N'Miranda', N'adquisiciones@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T11:55:47.697' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (42, N'Claudio ', N'Vial', N'cvial@ranco.cl', N'123456', 1, 4, 3, 16, CAST(N'2021-04-20T11:56:17.823' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (43, N'Cristian ', N'Benavente', N'cbenavente@ranco.cl', N'123456', 1, 4, 6, 13, CAST(N'2021-04-20T11:57:07.693' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (44, N'Cristian ', N'Leon', N'cleon@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T11:57:35.407' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (45, N'Cristian ', N'Saez', N'csaez@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T11:58:10.640' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (46, N'Daniela ', N'Maureira', N'dmaureira@ranco.cl', N'123456', 1, 4, 5, 29, CAST(N'2021-04-20T11:58:51.997' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (47, N'Daniela ', N'Muñoz Vasquez', N'dmunoz@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T11:59:46.763' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (48, N'Denuncias', N'Denuncias', N'denuncias@ranco.cl', N'123456', 1, 4, 1, 1, CAST(N'2021-04-20T12:00:37.750' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (49, N'Despacho', N'Despacho', N'despacho@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T12:01:19.630' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (50, N'Diego ', N'Bisquertt', N'dbisquertt@ranco.cl', N'123456', 1, 4, 2, 7, CAST(N'2021-04-20T12:01:54.420' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (51, N'Diego ', N'Martin', N'dmartin@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T12:02:41.910' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (52, N'Elsa ', N'Castillo', N'ecastillo@ranco.cl', N'123456', 1, 4, 7, 23, CAST(N'2021-04-20T12:04:20.143' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (53, N'Erwin ', N'Mena', N'emena@ranco.cl', N'123456', 1, 4, 2, 7, CAST(N'2021-04-20T12:04:49.610' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (54, N'Esteban ', N'Acevedo', N'eacevedo@ranco.cl', N'123456', 1, 4, 6, 13, CAST(N'2021-04-20T12:15:08.210' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (55, N'Evelyn ', N'Reyes', N'ereyes@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T12:16:09.780' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (56, N'Exportaciones', N'Exportaciones', N'exportaciones@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T12:20:03.153' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (57, N'Facturacion', N'Facturacion', N'facturacion@ranco.cl', N'123456', 1, 4, 1, 1, CAST(N'2021-04-20T12:20:32.587' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (58, N'Felix ', N'Morales', N'fmorales@ranco.cl', N'123456', 1, 4, 7, 21, CAST(N'2021-04-20T12:21:10.083' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (59, N'Fernanda ', N'Carvajal', N'fcarvajal@ranco.cl', N'123456', 1, 4, 7, 21, CAST(N'2021-04-20T12:22:02.723' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (60, N'Fernando', N'Soto', N'fsoto@ranco.cl', N'123456', 1, 4, 7, 19, CAST(N'2021-04-20T12:22:46.390' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (61, N'Firmpro ', N'Packing', N'firmpropacking@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T12:23:22.787' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (62, N'Francisco ', N'Rossel', N'frossel@ranco.cl', N'123456', 1, 4, 7, 23, CAST(N'2021-04-20T12:23:52.850' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (63, N'Frigorifico', N'Frigorifico', N'frigorifico@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T12:24:26.747' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (64, N'Geo ', N'Contreras', N'gcontreras@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T12:28:01.107' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (65, N'Graciela', N'Graciela', N'graciela@ranco.cl', N'123456', 1, 4, 8, 26, CAST(N'2021-04-20T12:29:00.040' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (66, N'Hector ', N'Lopez', N'hlopez@ranco.cl', N'123456', 1, 4, 7, 23, CAST(N'2021-04-20T12:29:45.843' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (67, N'Henry ', N'Mella', N'hmella@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T12:30:43.120' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (68, N'Info', N'Info', N'info@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T12:31:09.750' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (69, N'Jacqueline ', N'Neira', N'jneira@ranco.cl', N'123456', 1, 4, 8, 26, CAST(N'2021-04-20T12:32:39.197' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (70, N'Jhon ', N'Briceño', N'jbriceno@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T12:33:44.327' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (71, N'Jonathan ', N'Alvarado', N'jalvarado@ranco.cl', N'123456', 1, 4, 6, 13, CAST(N'2021-04-20T12:34:13.997' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (72, N'Jorge ', N'Gonzalez', N'jgonzalez@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T12:34:53.250' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (73, N'Jose Manuel ', N'Correa', N'jcorrea@ranco.cl', N'123456', 1, 4, 6, 13, CAST(N'2021-04-20T12:35:41.720' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (74, N'Jose ', N'Peña', N'jpena@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T12:36:15.903' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (75, N'Josefina ', N'Jahn', N'jjahn@ranco.cl', N'123456', 1, 4, 5, 9, CAST(N'2021-04-20T12:36:55.157' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (76, N'Joselyn ', N'Delgado', N'jdelgado@ranco.cl', N'123456', 1, 4, 2, 7, CAST(N'2021-04-20T12:38:29.083' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (77, N'Juan Ramon ', N'Balbi', N'jrbalbi@ranco.cl', N'123456', 1, 4, 7, 19, CAST(N'2021-04-20T12:39:09.483' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (78, N'Kevin ', N'Vergara', N'kvergara@ranco.cl', N'123456', 1, 4, 7, 23, CAST(N'2021-04-20T12:39:41.790' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (79, N'Lorenzo ', N'Aburto', N'laburto@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T12:41:47.410' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (80, N'Luis ', N'Marchant', N'lmarchant@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T12:42:27.700' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (81, N'Mantencion', N'Mantencion', N'mantencion@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T12:43:44.373' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (82, N'Manuel ', N'Villarroel', N'mvillarroel@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T12:52:24.170' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (83, N'Maria Angelica ', N'Pino', N'mapino@ranco.cl', N'123456', 1, 4, 1, 1, CAST(N'2021-04-20T12:57:17.303' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (84, N'Maria Jose ', N'Villalobos', N'mjvillalobos@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T12:57:56.547' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (85, N'Mirna ', N'Contreras', N'mcontreras@ranco.cl', N'123456', 1, 4, 5, 29, CAST(N'2021-04-20T12:58:26.477' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (86, N'monitorBPM', N'BPM', N'monitorbpm@ranco.cl', N'123456', 1, 4, 5, 9, CAST(N'2021-04-20T12:59:02.740' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (87, N'Natalia ', N'Rodriguez', N'investigacion@ranco.cl', N'123456', 1, 4, 5, 11, CAST(N'2021-04-20T12:59:36.143' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (88, N'Nelson ', N'Brito', N'nbrito@ranco.cl', N'123456', 1, 4, 7, 19, CAST(N'2021-04-20T13:00:34.330' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (89, N'Noreidys ', N'Guevara', N'nguevara@ranco.cl', N'123456', 1, 4, 7, 17, CAST(N'2021-04-20T13:01:13.530' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (90, N'Orlando ', N'Muñoz', N'omunoz@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T13:02:09.177' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (91, N'Osvaldo Hidalgo', N'Hidalgo', N'ohidalgo@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T13:02:43.240' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (92, N'Pablo ', N'Corral', N'pcorral@ranco.cl', N'123456', 1, 4, 6, 13, CAST(N'2021-04-20T13:04:04.940' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (93, N'Paletizaje', N'Paletizaje', N'paletizaje@ranco.cl', N'123456', 1, 4, 7, 23, CAST(N'2021-04-20T13:04:33.603' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (94, N'Paloma ', N'Ortiz', N'portiz@ranco.cl', N'123456', 1, 4, 7, 23, CAST(N'2021-04-20T13:05:51.427' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (95, N'Pamela ', N'Osorio', N'posorio@ranco.cl', N'123456', 1, 4, 5, 10, CAST(N'2021-04-20T13:06:18.877' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (96, N'Paola ', N'de la Fuente', N'pdelafuente@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T13:06:49.967' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (97, N'Patricio ', N'Diaz', N'pdiaz@ranco.cl', N'123456', 1, 4, 7, 23, CAST(N'2021-04-20T13:07:18.430' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (98, N'Patricio ', N'Mercado', N'pmercado@ranco.cl', N'123456', 1, 4, 7, 17, CAST(N'2021-04-20T13:10:42.457' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (99, N'Paulina ', N'Larredonda', N'plarredonda@ranco.cl', N'123456', 1, 4, 1, 1, CAST(N'2021-04-20T13:11:19.820' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (100, N'Paulina', N'Villalobos', N'pvillalobos@ranco.cl', N'123456', 1, 4, 7, 19, CAST(N'2021-04-20T13:12:02.133' AS DateTime), NULL, NULL, 1)
GO
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (101, N'Pedro ', N'Leal', N'pleal@ranco.cl', N'123456', 1, 4, 7, 23, CAST(N'2021-04-20T13:12:29.480' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (102, N'Personas ', N'Ranco', N'personas@ranco.cl', N'123456', 1, 4, 1, 1, CAST(N'2021-04-20T13:14:09.807' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (103, N'Porteria ', N'ranco', N'porteria@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T13:14:57.570' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (104, N'Raimundo ', N'Weason', N'rweason@ranco.cl', N'123456', 1, 4, 8, 26, CAST(N'2021-04-20T13:15:50.240' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (105, N'Remuneraciones', N'Remuneraciones', N'remuneraciones@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T13:16:35.500' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (106, N'Repaletizaje', N'Repaletizaje', N'repaletizaje@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T13:17:20.400' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (107, N'Ricardo ', N'Villagra', N'rvillagra@ranco.cl', N'123456', 1, 4, 7, 22, CAST(N'2021-04-20T13:18:14.850' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (108, N'Rocio ', N'Apablaza', N'prevencion@ranco.cl', N'123456', 1, 4, 5, 9, CAST(N'2021-04-20T13:18:45.773' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (109, N'Rocio ', N'Arriola', N'rarriola@ranco.cl', N'123456', 1, 4, 5, 11, CAST(N'2021-04-20T13:19:18.520' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (110, N'Rodrigo ', N'Cabello', N'rcabello@ranco.cl', N'123456', 1, 4, 7, 17, CAST(N'2021-04-20T13:19:55.597' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (111, N'Rodrigo ', N'Sanchez', N'rsanchez@ranco.cl', N'123456', 1, 4, 6, 13, CAST(N'2021-04-20T13:20:23.967' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (112, N'Romana', N'Romana', N'romana@ranco.cl', N'123456', 1, 4, 7, 23, CAST(N'2021-04-20T13:20:50.793' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (113, N'Sadema', N'Sadema', N'sadema@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T13:22:07.093' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (114, N'Sag', N'Sag', N'sag@ranco.cl', N'123456', 1, 4, 7, 22, CAST(N'2021-04-20T13:22:31.643' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (115, N'SDT SII', N'SDT SII', N'sdtsii@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T13:23:48.993' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (116, N'Sebastian ', N'Henriquez', N'shenriquez@ranco.cl', N'123456', 1, 4, 2, 7, CAST(N'2021-04-20T13:24:31.913' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (117, N'Sebastian ', N'Morales', N'smorales@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T13:25:26.207' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (118, N'Sergio ', N'Manquez', N'smanquez@ranco.cl', N'123456', 1, 4, 5, 11, CAST(N'2021-04-20T13:26:01.940' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (119, N'Supervisor ', N'Despacho', N'supervisordespacho@ranco.cl', N'123456', 1, 4, 7, 18, CAST(N'2021-04-20T13:26:47.280' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (120, N'Supervisor ', N'Proceso Calidad', N'supervisorprocesocalidad@ranco.cl', N'123456', 1, 4, 5, 10, CAST(N'2021-04-20T13:28:27.360' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (121, N'Úrsula ', N'Paredes', N'uparedes@ranco.cl', N'123456', 1, 4, 5, 9, CAST(N'2021-04-20T13:28:57.603' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (122, N'Valentina ', N'Acuña', N'vnacuna@ranco.cl', N'123456', 1, 4, 1, 1, CAST(N'2021-04-20T13:29:21.640' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (123, N'Victor ', N'Farias', N'vfarias@ranco.cl', N'123456', 1, 4, 7, 17, CAST(N'2021-04-20T13:30:01.083' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (124, N'Victor ', N'Reyes', N'vreyes@ranco.cl', N'123456', 1, 4, 1, 5, CAST(N'2021-04-20T13:30:27.680' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (125, N'Victoria ', N'Zapata', N'vzapata@ranco.cl', N'123456', 1, 4, 6, 13, CAST(N'2021-04-20T13:30:57.203' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (126, N'Viviana ', N'Díaz', N'vdiaz@ranco.cl', N'123456', 1, 4, 7, 20, CAST(N'2021-04-20T13:31:29.110' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (127, N'Yakari ', N'Gutierrez Loyola', N'ygutierrez@ranco.cl', N'123456', 1, 4, 5, 29, CAST(N'2021-04-20T13:32:58.667' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (128, N'Yohany ', N'Poo', N'YPoo@ranco.cl', N'123456', 1, 4, 5, 9, CAST(N'2021-04-20T13:33:43.870' AS DateTime), NULL, NULL, 1)
INSERT [dbo].[tm_usuario] ([usu_id], [usu_nom], [usu_ape], [usu_correo], [usu_pass], [rol_id], [grupo_id], [area_id], [suba_id], [fech_crea], [fech_modi], [fech_elim], [est]) VALUES (129, N'Bodega', N'MM', N'bodegamm@ranco.cl', N'123456', 1, 4, 7, 17, CAST(N'2021-04-26T11:00:39.800' AS DateTime), NULL, NULL, 1)
SET IDENTITY_INSERT [dbo].[tm_usuario] OFF
GO
ALTER TABLE [dbo].[tm_usuario] ADD  CONSTRAINT [DF_tm_usuario_suba_id]  DEFAULT ((0)) FOR [suba_id]
GO
USE [master]
GO
ALTER DATABASE [GESTION] SET  READ_WRITE 
GO
