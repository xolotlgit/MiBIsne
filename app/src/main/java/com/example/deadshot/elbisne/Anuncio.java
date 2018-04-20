package com.example.deadshot.elbisne;

/**
 * Created by DEADSHOT on 06/03/2018.
 */

public class Anuncio {

    private  String IdNego;
    private  String NobreAnuncio;
    private  String FechaInicio;
    private  String FechaFin;
    private  String ImgUrl;

    public Anuncio(String idNego, String nobreAnuncio, String fechaInicio, String fechaFin, String imgUrl) {
        IdNego = idNego;
        NobreAnuncio = nobreAnuncio;
        FechaInicio = fechaInicio;
        FechaFin = fechaFin;
        ImgUrl = imgUrl;
    }

    public String getIdNego() {
        return IdNego;
    }

    public void setIdNego(String idNego) {
        IdNego = idNego;
    }

    public String getNobreAnuncio() {
        return NobreAnuncio;
    }

    public void setNobreAnuncio(String nobreAnuncio) {
        NobreAnuncio = nobreAnuncio;
    }

    public String getFechaInicio() {
        return FechaInicio;
    }

    public void setFechaInicio(String fechaInicio) {
        FechaInicio = fechaInicio;
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
