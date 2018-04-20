package com.example.deadshot.elbisne;

/**
 * Created by DEADSHOT on 01/03/2018.
 */
public class Contacto {

    private  String NombreContacto;
    private  String TelefonoContacto;
    private  String CorreoContacto;

    public Contacto(String nombreContacto, String telefonoContacto, String correoContacto) {
        NombreContacto = nombreContacto;
        TelefonoContacto = telefonoContacto;
        CorreoContacto = correoContacto;
    }

    public String getNombreContacto() {
        return NombreContacto;
    }

    public void setNombreContacto(String nombreContacto) {
        NombreContacto = nombreContacto;
    }

    public String getTelefonoContacto() {
        return TelefonoContacto;
    }

    public void setTelefonoContacto(String telefonoContacto) {
        TelefonoContacto = telefonoContacto;
    }

    public String getCorreoContacto() {
        return CorreoContacto;
    }

    public void setCorreoContacto(String correoContacto) {
        CorreoContacto = correoContacto;
    }
}
