import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';

class ApiService {
  //servicio registro de salida
  //static const baseUrl = 'http://192.168.31.196/api_proyecto2/';
  static const baseUrl = 'http://10.0.8.145/api_proyecto2/';
  static Future<List<dynamic>?> fetchNinosSalida() async {
    final response = await http.get(Uri.parse('${baseUrl}get_ninos.php'));
    if (response.statusCode == 200) {
      return json.decode(response.body)['data'];
    }
    return null;
  }

  static Future<List<dynamic>?> fetchEncargados() async {
    final response = await http.get(Uri.parse('${baseUrl}get_encargados.php'));
    if (response.statusCode == 200) {
      return json.decode(response.body)['data'];
    }
    return null;
  }

  static Future<Map<String, dynamic>> registrarSalida({
    required int? idNino,
    required String? idEncargado,
    required DateTime fecha,
    required String hora,
  }) async {
    final response = await http.post(
      Uri.parse('${baseUrl}register_salida.php'),
      body: {
        'id_nino': idNino.toString(),
        'id_encargado': idEncargado!,
        'fecha': fecha.toIso8601String().split('T').first,
        'hora': hora,
      },
    );
    return json.decode(response.body);
  }

  //servicio de registro de asitencia
  static Future<List<dynamic>> fetchGrupos() async {
    final response = await http.get(
        //Uri.parse('http://192.168.31.196/api_notificaciones/get_grupos.php'));
        Uri.parse('http://10.0.8.145/api_notificaciones/get_grupos.php'));
    if (response.statusCode == 200) {
      final Map<String, dynamic> jsonResponse = json.decode(response.body);
      return jsonResponse['data'];
    } else {
      throw Exception('Error al cargar los grupos');
    }
  }

  static Future<List<dynamic>> fetchNinos(int grupoId) async {
    //final response = await http.get(Uri.parse('http://192.168.31.196/api_notificaciones/get_ninos_by_grupo.php?grupo_id=$grupoId'));
    final response = await http.get(Uri.parse(
        'http://10.0.8.145/api_notificaciones/get_ninos_by_grupo.php?grupo_id=$grupoId'));
    if (response.statusCode == 200) {
      final Map<String, dynamic> jsonResponse = json.decode(response.body);
      return jsonResponse['data'];
    } else {
      throw Exception('Error al cargar los niños');
    }
  }

  static Future<void> registrarAsistencia(int ninoId, String estado,
      int? grupoId, BuildContext context, String ninoNombre) async {
    final response = await http.post(
      //Uri.parse('http://192.168.31.196/api_notificaciones/register_asistencia.php'),
      Uri.parse('http://10.0.8.145/api_notificaciones/register_asistencia.php'),
      body: {
        'nino_id': ninoId.toString(),
        'grupo_id': grupoId.toString(),
        'fecha': DateTime.now().toIso8601String().split('T').first,
        'estado': estado,
      },
    );

    if (response.statusCode == 200) {
      final jsonResponse = json.decode(response.body);

      // Verificar si la respuesta es exitosa y mostrar el mensaje con el nombre del niño
      if (jsonResponse['status'] == 'success') {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
              content: Text(
                  "Asistencia registrada correctamente para $ninoNombre , con id $ninoId")),
        );
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text("Error al registrar la asistencia")),
        );
      }
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Error al conectar con el servidor")),
      );
    }
  }
}
