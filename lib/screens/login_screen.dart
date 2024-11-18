import 'package:flutter/material.dart';
import '../services/auth_service.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final AuthService _authService = AuthService();
  final TextEditingController _usuarioController = TextEditingController();
  final TextEditingController _contrasenaController = TextEditingController();

  int _intentosRestantes = 3;
  bool _loginDeshabilitado = false;

  void _login() async {
    String usuario = _usuarioController.text;
    String contrasena = _contrasenaController.text;

    bool success = await _authService.login(usuario, contrasena);

    if (success) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Inicio de sesión exitoso")),
      );
      Navigator.pushReplacementNamed(context, '/home_screen');
    } else {
      setState(() {
        _intentosRestantes -= 1;
      });

      if (_intentosRestantes <= 0) {
        setState(() {
          _loginDeshabilitado = true;
        });
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
              content: Text("Se han agotado los intentos. Intente más tarde.")),
        );
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(
              content: Text(
                  "Usuario o contraseña incorrectos. Intentos restantes: $_intentosRestantes")),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(24.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                'Inicio de Sesión',
                style: TextStyle(
                  fontSize: 28,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFFD4AF37), // Dorado
                ),
              ),
              SizedBox(height: 24),
              TextField(
                controller: _usuarioController,
                decoration: InputDecoration(
                  labelText: 'Usuario',
                  labelStyle: TextStyle(color: Colors.grey[700]),
                  filled: true,
                  fillColor: Colors.white,
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                    borderSide: BorderSide(color: Color(0xFFD4AF37)), // Dorado
                  ),
                  focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: Color(0xFFD4AF37), width: 2),
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
                style: TextStyle(color: Colors.black),
              ),
              SizedBox(height: 16),
              TextField(
                controller: _contrasenaController,
                obscureText: true,
                decoration: InputDecoration(
                  labelText: 'Contraseña',
                  labelStyle: TextStyle(color: Colors.grey[700]),
                  filled: true,
                  fillColor: Colors.white,
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                    borderSide: BorderSide(color: Color(0xFFD4AF37)), // Dorado
                  ),
                  focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: Color(0xFFD4AF37), width: 2),
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
                style: TextStyle(color: Colors.black),
              ),
              SizedBox(height: 24),
              ElevatedButton(
                onPressed: _loginDeshabilitado ? null : _login,
                style: ElevatedButton.styleFrom(
                  backgroundColor: _loginDeshabilitado
                      ? Colors.grey
                      : Color(0xFFD4AF37), // Dorado
                  foregroundColor: Colors.white,
                  padding: EdgeInsets.symmetric(horizontal: 40, vertical: 15),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                ),
                child: Text(
                  'Iniciar Sesión',
                  style: TextStyle(fontSize: 18),
                ),
              ),
              if (_loginDeshabilitado)
                Padding(
                  padding: const EdgeInsets.only(top: 20),
                  child: Text(
                    'Intentos agotados, por favor inténtelo más tarde.',
                    style: TextStyle(color: Colors.redAccent),
                  ),
                ),
            ],
          ),
        ),
      ),
    );
  }
}
