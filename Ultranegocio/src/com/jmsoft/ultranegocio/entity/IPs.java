package com.jmsoft.ultranegocio.entity;

public class IPs {
	
//	public final static String ip = "http://192.168.1.104/ultranegocio/sistema";
	public final static String ip = "http://10.0.2.2/ultranegocio/sistema";
	
	public final static String signIn = ip + "/api/usuarios/add.json";
	public final static String login = ip + "/api/users/authorize.json";
	public final static String announcements = ip + "/api/anuncios.json";
	public final static String addAnnouncement = ip + "/api/anuncios/add";
	public final static String listUsers = ip + "/api/usuarios.json";
}
