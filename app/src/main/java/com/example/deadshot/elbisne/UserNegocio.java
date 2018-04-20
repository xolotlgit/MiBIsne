package com.example.deadshot.elbisne;

/**
 * Created by DEADSHOT on 09/03/2018.
 */

public class UserNegocio {
    private  String IdNegocio;
    private  String NombreNegocio;
    private  String DescripcionNegocio;
    private  String FechaIni;
    private  String FechaFin;
    private  String ImgUrl;

    public UserNegocio(String idNegocio, String nombreNegocio, String descripcionNegocio, String fechaIni, String fechaFin, String imgUrl) {
        IdNegocio = idNegocio;
        NombreNegocio = nombreNegocio;
        DescripcionNegocio = descripcionNegocio;
        FechaIni = fechaIni;
        FechaFin = fechaFin;
        ImgUrl = imgUrl;
    }

    public String getIdNegocio() {
        return IdNegocio;
    }

    public void setIdNegocio(String idNegocio) {
        IdNegocio = idNegocio;
    }

    public String getNombreNegocio() {
        return NombreNegocio;
    }

    public void setNombreNegocio(String nombreNegocio) {
        NombreNegocio = nombreNegocio;
    }

    public String getDescripcionNegocio() {
        return DescripcionNegocio;
    }

    public void setDescripcionNegocio(String descripcionNegocio) {
        DescripcionNegocio = descripcionNegocio;
    }

    public String getFechaIni() {
        return FechaIni;
    }

    public void setFechaIni(String fechaIni) {
        FechaIni = fechaIni;
    }

    public String getFechaFin() {
        return FechaFin;
    }

    public void setFechaFin(String fechaFin) {
        FechaFin = fechaFin;
    }

    public String getImgUrl() {
        return ImgUrl;
    }

    public void setImgUrl(String imgUrl) {
        ImgUrl = imgUrl;
    }
}
