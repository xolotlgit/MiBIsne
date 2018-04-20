package com.example.deadshot.elbisne;

/**
 * Created by DEADSHOT on 20/03/2018.
 */

public class SearchNegocio {
    private String IdNegocio;
    private String NombreNegocio;
    private String Descripcion;
    private String UrlImagen;

    public SearchNegocio(String idNegocio, String nombreNegocio, String descripcion, String urlImagen) {
        IdNegocio = idNegocio;
        NombreNegocio = nombreNegocio;
        Descripcion = descripcion;
        UrlImagen = urlImagen;
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

    public String getDescripcion() {
        return Descripcion;
    }

    public void setDescripcion(String descripcion) {
        Descripcion = descripcion;
    }

    public String getUrlImagen() {
        return UrlImagen;
    }

    public void setUrlImagen(String urlImagen) {
        UrlImagen = urlImagen;
    }
}
