import 'package:flutter/material.dart';

class NinoTile extends StatelessWidget {
  final dynamic nino;
  final VoidCallback onPresente;
  final VoidCallback onAusente;

  NinoTile({
    required this.nino,
    required this.onPresente,
    required this.onAusente,
  });

  @override
  Widget build(BuildContext context) {
    return ListTile(
      title: Text(
        '${nino['nombre']} ${nino['apellido_paterno']}',
        style: TextStyle(color: Colors.black), // Color blanco para el nombre
      ),
      subtitle: Text(
        'Edad: ${nino['edad']}',
        style: TextStyle(
            color: Colors.black38), // Color blanco con opacidad para la edad
      ),
      trailing: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          IconButton(
            icon: Icon(Icons.check, color: Colors.green),
            onPressed: onPresente,
          ),
          IconButton(
            icon: Icon(Icons.close, color: Colors.red),
            onPressed: onAusente,
          ),
        ],
      ),
    );
  }
}
