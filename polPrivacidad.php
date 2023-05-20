<?php
    include_once "./complementos/cabecera_intro.php";

    if(isset($_SESSION)){
        session_destroy();
    }
?>
<body>
    <div class="container-fluid cabecera">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-6 text-center tx-white">
                <img src="./img/4bar_logo.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="container-fluid cuerpo">
        <div class="row d-flex justify-content-center align-items-start vh-100 pt-4">
            <div class="col-8 text-start tx-black ">
                <h1 class="text-center py-3">POLÍTICA DE PRIVACIDAD</h1>
                    <h5>En cumplimiento de lo dispuesto en el Reglamento UE 2016/679 General de Protección de Datos (RGPD), la Ley Orgánica 3/2018 de Protección de Datos Personales y de garantía de derechos digitales (LOPDGDD) y demás normativa aplicable se informa de lo siguiente:</h5>

                    <h4><strong>Responsable</strong></h4>
                    <h5>Los datos personales que nos facilite bien a través de esta página web o por otros medios van a ser tratados por 4BAR S.L.</h5>
                    <h5>Email de contacto: 4bar-info@gmail.com</h5>
                    <h4><strong>Finalidad</strong></h4>
                    <h5>Los datos personales únicamente serán tratados con la finalidad de gestionar su relación con nosotros.</h5>
                    <ul>
                        <li>
                    <h5>Contacto: utilizaremos los datos para atender su solicitud, responderle a su pregunta o facilitarle la información solicitada.</h5>
                    </li>
                        <li>
                    <h5>Si Vd. nos envía un CV lo guardaremos durante un máximo de un año con la finalidad de tenerle en cuenta en nuestros procesos de selección.</h5>
                    </li>
                        <li>
                    <h5>Si Vd. es cliente o proveedor, sólo utilizaremos los datos para gestionar su relación comercial con nuestra compañía y para mantenerle informado de nuestras noticias y novedades.</h5>
                    </li>
                    </ul>
                    <h4><strong>Categorías de datos</strong></h4>
                    <h5>Trataremos sólo los datos necesarios para atender su petición o prestarle el servicio. Estos datos podrán ser meramente identificativos de clientes, proveedores, contactos y candidatos.</h5>
                    <h4><strong>Legitimación</strong></h4>
                    <h5>En el caso de clientes y proveedores basamos el tratamiento en la propia ejecución del contrato.</h5>
                    <h5>Para los contactos, CVs y otra peticiones de información basamos el tratamiento en su consentimiento.</h5>
                    <h4><strong>Conservación</strong></h4>
                    <h5>Conservaremos los datos el tiempo imprescindible para cumplir con la finalidad expuesta y atender a nuestras obligaciones legales. Transcurrido dicho plazo procederemos a su destrucción.</h5>
                    <h4><strong>Destinatarios y transferencias internacionales</strong></h4>
                    <h5>Los datos personales sólo serán utilizados por nuestra compañía.</h5>
                    <h5>No cederemos ni comunicaremos sus datos a terceros excepto para el cumplimiento de las obligaciones legales a las que vengamos obligados por razón de nuestro negocio (Administraciones Públicas, entidades financieras, aseguradoras).</h5>
                    <h5>Es posible que trabajemos con proveedores externos y con herramientas, algunas de las cuales pueden situarse fuera de la Unión Europea pero nos hemos asegurado de que cumplen con la normativa aplicable, hemos suscrito los correspondientes acuerdos y en el caso de las transferencias internacionales hemos comprobado que ofrecen garantías suficientes de cumplimiento con arreglo a lo dispuesto en el RGPD.</h5>
                    <h4><strong>Seguridad</strong></h4>
                    <h5>Los responsables han adoptado cuantas medidas de seguridad técnicas y organizativas necesarias para garantizar la confidencialidad, integridad y disponibilidad de los datos personales teniendo en cuenta el estado de la técnica, los costes de aplicación y la naturaleza, el alcance, el contexto y los fines de los tratamientos realizados, así como los riesgos en términos de probabilidad y gravedad para los derechos y libertades de las personas físicas.</h5>
                    <h4><strong>Derechos</strong></h4>
                    <h5>Le informamos que podrá ejercer en cualquier momento los derechos de acceso, rectificación, portabilidad y supresión de sus datos y los de limitación y oposición a su tratamiento. Para ello puede dirigirse a nosotros en <a href="mailto:arestheferret@gmail.com">4bar-info@gmail.com</a> adjuntando una copia de su DNI e indicando el derecho que desee ejercitar. También puede dirigirse a nuestro domicilio social.</h5>
                    <h5>Si considera que el tratamiento no se ajusta a la normativa vigente de protección de datos, tiene derecho a presentar una reclamación ante la autoridad de control (Agencia Española de Protección de Datos) en <a href="http://www.aepd.es">www.aepd.es</a>. Aunque es compromiso de los responsables de tratamiento garantizar la privacidad y la seguridad de los datos y resolver internamente cualquier cuestión con ellas relacionada.</h5>
                    &nbsp;
                    <h5></h5>
                    <h5>Actualizada en 19 de noviembre de 2021</h5>
            </div>
        </div>
    </div>
<?php
    include "./error/errores_index.php";
?>
</body>
</html>