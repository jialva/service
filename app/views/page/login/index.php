<form id="wrapper" onsubmit="return false">
    <div id="box" class="animated bounceIn">
        <div id="top_header"><h5>Valide sus datos</h5></div>
        <div id="inputs">
            <div class="form-block"><input type="text" placeholder="Usuario" id="usuario"> <i class="icon-user2"></i></div>
            <div class="form-block"><input type="password" placeholder="Password" id="password"><i class="icon-lock2"></i></div>
            <!--<div class="form-block">
                <label style="color: #000;margin-left: 8%;">Cambiar imagen</label>
                <canvas id="capatcha" style="width:84%;  border: 1px solid #ccc; margin-left: 8%;" height="52"></canvas>
            </div>-->
        </div>
            <input type="submit" onclick="ingresar()" id="btningresar" value="Ingresar">
    </div>
</form>