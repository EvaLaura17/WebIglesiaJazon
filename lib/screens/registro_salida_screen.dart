import 'package:flutter/material.dart';
import '../services/api_service.dart';

class RegistroSalidaScreen extends StatefulWidget {
  @override
  _RegistroSalidaScreenState createState() => _RegistroSalidaScreenState();
}

class _RegistroSalidaScreenState extends State<RegistroSalidaScreen> {
  List<dynamic> ninos = [];
  List<dynamic> encargados = [];
  int? selectedNinoId;
  String? selectedEncargadoId;

  @override
  void initState() {
    super.initState();
    fetchNinos();
    fetchEncargados();
  }

  Future<void> fetchNinos() async {
    final response = await ApiService.fetchNinosSalida();
    if (response != null) {
      setState(() {
        ninos = response;
      });
    }
  }

  Future<void> fetchEncargados() async {
    final response = await ApiService.fetchEncargados();
    if (response != null) {
      setState(() {
        encargados = response;
      });
    }
  }

  Future<void> registrarSalida() async {
    final response = await ApiService.registrarSalida(
      idNino: selectedNinoId,
      idEncargado: selectedEncargadoId,
      fecha: DateTime.now(),
      hora: TimeOfDay.now().format(context),
    );

    if (response['status'] == 'success') {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Salida registrada con éxito")),
      );
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text("Error al registrar la salida")),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white, // Fondo blanco
      appBar: AppBar(
        title: Text(
          'Registro de Salida',
          style: TextStyle(
            fontWeight: FontWeight.bold,
            color: Colors.white,
          ),
        ),
        backgroundColor: Color(0xFFD4AF37), // Fondo dorado
        centerTitle: true,
        iconTheme: IconThemeData(color: Colors.black), // Ícono negro
      ),
      body: Center(
        child: Padding(
          padding: const EdgeInsets.all(20.0),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              // Dropdown para seleccionar niño
              DropdownButtonFormField<int>(
                hint: Text(
                  "Selecciona un niño",
                  style: TextStyle(color: Colors.black),
                ),
                value: selectedNinoId,
                items: ninos.map<DropdownMenuItem<int>>((nino) {
                  return DropdownMenuItem<int>(
                    value: int.tryParse(nino['id'].toString()),
                    child: Text(
                      '${nino['nombre']} ${nino['apellido_paterno']}',
                      style: TextStyle(color: Colors.black),
                    ),
                  );
                }).toList(),
                onChanged: (value) {
                  setState(() {
                    selectedNinoId = value;
                  });
                },
                decoration: InputDecoration(
                  filled: true,
                  fillColor: Colors.grey[200], // Fondo claro
                  border: InputBorder.none, // Sin bordes
                  contentPadding: EdgeInsets.symmetric(horizontal: 10),
                ),
              ),
              SizedBox(height: 20),

              // Dropdown para seleccionar encargado
              DropdownButtonFormField<String>(
                hint: Text(
                  "Selecciona un encargado",
                  style: TextStyle(color: Colors.black),
                ),
                value: selectedEncargadoId,
                items: encargados.map<DropdownMenuItem<String>>((encargado) {
                  return DropdownMenuItem<String>(
                    value: encargado['id_encargado'],
                    child: Text(
                      '${encargado['nombre']} ${encargado['apellido']}',
                      style: TextStyle(color: Colors.black),
                    ),
                  );
                }).toList(),
                onChanged: (value) {
                  setState(() {
                    selectedEncargadoId = value;
                  });
                },
                decoration: InputDecoration(
                  filled: true,
                  fillColor: Colors.grey[200], // Fondo claro
                  border: InputBorder.none, // Sin bordes
                  contentPadding: EdgeInsets.symmetric(horizontal: 10),
                ),
              ),
              SizedBox(height: 20),

              // Botón para registrar salida
              ElevatedButton(
                onPressed: registrarSalida,
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Icon(Icons.check_circle, color: Colors.white),
                    SizedBox(width: 10),
                    Text(
                      'Registrar Salida',
                      style: TextStyle(fontSize: 16, color: Colors.white),
                    ),
                  ],
                ),
                style: ElevatedButton.styleFrom(
                  backgroundColor: Color(0xFFD4AF37), // Fondo negro
                  padding:
                      EdgeInsets.symmetric(vertical: 15.0, horizontal: 30.0),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(10.0),
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
