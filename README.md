PLANTEAMIENTO DEL PROBLEMA

PROBLEMA
Se desarrolla una Aplicación Web para la Gestión de Visitas Médicas y Control de Nómina en una Empresa Farmacéutica 

DESCRIPCIÓN DEL PROBLEMA A RESOLVER
Una empresa farmacéutica necesita automatizar la gestión de actividades del personal que realiza visitas médicas en distintos departamentos del país. Actualmente, los procesos de registro de empleados, control de gastos, cálculo de bonificaciones y generación de nómina se llevan a cabo de manera manual, lo que genera errores, retrasos y pérdida de información.

La empresa solicita el desarrollo de una aplicación web en PHP con MySQL que permita optimizar el control de visitas médicas, gastos de operación y cálculo de la nómina mensual, integrando todas las funciones en un solo sistema confiable y accesible.

Requisitos
1. Gestión de Usuarios:
Inicio de sesión con autenticación de credenciales (tabla usuarios).
Control de acceso según el perfil del usuario.

2. Gestión de Empleados y Departamentos:
Registro de empleados con datos personales y laborales.
Registro de departamentos, incluyendo distancias recorridas.
Cálculo automático de gastos de combustible (distancia × 30.54).

3. Gestión de Gastos:
Registro de alimentación, alojamiento, combustible y otros gastos en cada visita.
Generación de reportes detallados por empleado y por periodo (tabla informe gastos).

4. Bonificaciones por Ventas:
Cálculo automático de bonificación según ventas alcanzadas:
≥ Q40,000 → 15%
≥ Q25,000 → 10%
≤ Q25,000 → 5%

5. Cálculo de Nómina:
IGSS = (Sueldo base + bonificación) × 0.0483
Sueldo líquido = Sueldo base + bonificación − IGSS − otros descuentos
Generación de reportes individuales y globales de nómina mensual.Requerimientos Técnicos

Frontend:
Interfaz de usuario desarrollada en HTML, PHP y Bootstrap.
Formularios web claros, modernos y funcionales.
Compatibilidad con dispositivos móviles y de escritorio.

Backend:
Base de datos en MySQL (bd_visitasmedicas) con las tablas:
usuarios
empleados
departamentos
informe gastos
bonificación
nomina
Conexión segura a la base de datos (archivo conexion.php).
Lógica implementada en PHP 8+ ejecutándose en XAMPP.

Seguridad:
Autenticación y autorización de usuarios.
Validación de entradas en formularios para evitar inyecciones SQL.

Proceso de Desarrollo

Análisis de Requisitos:
Reunión con el personal administrativo para definir necesidades y flujos de trabajo.

Diseño del Sistema:
Elaboración de diagramas de base de datos y diseño de interfaces web.

Desarrollo: Creación de los módulos principales:
login.php
menu.php
departamentos.php
bonificacion.php
nomina.php
informe_gastos.php

Pruebas:
Validación de cálculos, formularios y seguridad.

Implementación: Despliegue en servidor local con XAMPP (/htdocs).
Capacitación: Entrenamiento al personal de recursos humanos y supervisores.
Mantenimiento: Corrección de errores y actualizaciones del sistema.

Objetivos:
Automatizar el control de visitas médicas realizadas por los empleados.
Optimizar el cálculo de gastos, bonificaciones y nómina mensual.
Reducir errores derivados de cálculos manuales y pérdida de registros.
Ofrecer reportes confiables para la toma de decisiones gerenciales
Proporcionar una plataforma unificada que centralice toda la información de empleados, departamentos y gastos
