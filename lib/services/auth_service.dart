import 'package:http/http.dart' as http;
import 'dart:convert';

class AuthService {
  Future<bool> login(String usuario, String contrasena) async {
    //final response = await http.post(Uri.parse('http://192.168.31.196/api_proyecto2/login.php'),
    final response = await http.post(
      Uri.parse('http://10.0.8.145/api_proyecto2/login.php'),
      body: {
        'usuario': usuario,
        'contrasena': contrasena,
      },
    );

    final jsonResponse = json.decode(response.body);
    return jsonResponse['status'] == 'success';
  }
}
