import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../widgets/grupo_dropdown.dart';
import '../widgets/nino_tile.dart';

class AsistenciaScreen extends StatefulWidget {
  @override
  _AsistenciaScreenState createState() => _AsistenciaScreenState();
}

class _AsistenciaScreenState extends State<AsistenciaScreen> {
  List<dynamic> grupos = [];
  List<dynamic> ninos = [];
  int? selectedGrupoId;

  @override
  void initState() {
    super.initState();
    fetchGrupos();
  }

  // Funciones para obtener datos de la API
  Future<void> fetchGrupos() async {
    grupos = await ApiService.fetchGrupos();
    setState(() {});
  }

  Future<void> fetchNinos(int grupoId) async {
    ninos = await ApiService.fetchNinos(grupoId);
    setState(() {});
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color.fromARGB(255, 255, 255, 255), // Fondo oscuro
      appBar: AppBar(
        title: Text(
          'Registro de Asistencia',
          style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
        ),
        backgroundColor: Color(0xFFD4AF37),
        foregroundColor: Colors.white70,
        centerTitle: true,
      ),
      body: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 20.0, vertical: 10.0),
        child: Column(
          children: [
            // Dropdown para grupos
            GrupoDropdown(
              grupos: grupos,
              selectedGrupoId: selectedGrupoId,
              onChanged: (value) {
                setState(() {
                  selectedGrupoId = value;
                  fetchNinos(value!);
                });
              },
            ),
            SizedBox(height: 20),
            // Lista de niños
            Expanded(
              child: ListView.builder(
                itemCount: ninos.length,
                itemBuilder: (context, index) {
                  return NinoTile(
                    nino: ninos[index],
                    onPresente: () => ApiService.registrarAsistencia(
                        ninos[index]['id'],
                        'Presente',
                        selectedGrupoId,
                        context,
                        ninos[index]['nombre']),
                    onAusente: () => ApiService.registrarAsistencia(
                        ninos[index]['id'],
                        'Ausente',
                        selectedGrupoId,
                        context,
                        ninos[index]['nombre']),
                  );
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}
