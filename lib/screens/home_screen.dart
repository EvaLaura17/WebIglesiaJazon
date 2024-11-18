import 'package:flutter/material.dart';
import 'registro_salida_screen.dart';
import 'asistencia_screen.dart';

class HomeScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white, // Fondo principal blanco
      appBar: AppBar(
        title: Text(
          'Registros',
          style: TextStyle(
            fontWeight: FontWeight.bold,
            color: Colors.white,
          ),
        ),
        backgroundColor: Color(0xFFD4AF37), // Dorado
        centerTitle: true,
      ),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text(
                'Seleccione una opción:',
                style: TextStyle(
                  color: Color(0xFFD4AF37), // Dorado
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                ),
              ),
              SizedBox(height: 30),
              ElevatedButton(
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(builder: (context) => AsistenciaScreen()),
                  );
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: Color(0xFFD4AF37), // Dorado
                  foregroundColor: Colors.white,
                  padding: EdgeInsets.symmetric(horizontal: 40, vertical: 15),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                  elevation: 5,
                ),
                child: Text(
                  'Registro de Asistencia',
                  style: TextStyle(fontSize: 18),
                ),
              ),
              SizedBox(height: 20),
              ElevatedButton(
                onPressed: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                        builder: (context) => RegistroSalidaScreen()),
                  );
                },
                style: ElevatedButton.styleFrom(
                  backgroundColor: Color(0xFFD4AF37), // Dorado
                  foregroundColor: Colors.white,
                  padding: EdgeInsets.symmetric(horizontal: 40, vertical: 15),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10),
                  ),
                  elevation: 5,
                ),
                child: Text(
                  'Registro de Salida',
                  style: TextStyle(fontSize: 18),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
