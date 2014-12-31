<form method="post" action="<?= Link::Url('user', 'login.json') ?>">
    <p>
        <label>Usuario </label>
        <input type="text" name="user" />
    </p>
    
    <p>
        <label>Clave </label>
        <input type="password" name="pass" />
    </p>
    
    <p>
        <input type="submit" />
    </p>
</form>

<form method="post" action="<?= Link::Url('vehicle', 'add.json') ?>">
    <p>
        <label>IMEI </label>
        <input type="text" name="idvehiculo" />
    </p>
    
    <p>
        <label>codigo </label>
        <input type="text" name="codigo_activacion" />
    </p>
    
    <p>
        <label>token </label>
        <input type="text" name="token" />
    </p>
    
    <p>
        <input type="submit" />
    </p>
</form>
<h1>Alerta!</h1>
<h2>Esto no es un simulacro.</h2>