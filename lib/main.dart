import 'package:flutter/material.dart';
import 'package:registros/screens/login_screen.dart';
import 'screens/login_screen.dart';
import 'screens/home_screen.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Registro de Asistencia',
      theme: ThemeData(primarySwatch: Colors.blue),
      routes: {
        '/': (context) => LoginScreen(),
        '/home_screen': (context) =>
            HomeScreen(), // Ruta para la pantalla principal
      },
    );
  }
}
