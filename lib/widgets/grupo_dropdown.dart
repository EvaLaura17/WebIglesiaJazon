import 'package:flutter/material.dart';

class GrupoDropdown extends StatelessWidget {
  final List<dynamic> grupos;
  final int? selectedGrupoId;
  final ValueChanged<int?> onChanged;

  GrupoDropdown({
    required this.grupos,
    required this.selectedGrupoId,
    required this.onChanged,
  });

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 10.0),
      child: DropdownButtonFormField<int>(
        hint: Text(
          "Selecciona un grupo",
          style: TextStyle(
              color: Colors
                  .white), // Color del hint cuando no se ha seleccionado nada
        ),
        value: selectedGrupoId,
        style: TextStyle(color: Colors.black), // Color del texto seleccionado
        decoration: InputDecoration(
          filled: true,
          fillColor: Color(0xFFD4AF37), // Fondo del campo
          contentPadding:
              EdgeInsets.symmetric(vertical: 12.0, horizontal: 10.0),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(10.0),
            borderSide: BorderSide.none,
          ),
          enabledBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(10.0),
            borderSide: BorderSide(
                color: const Color.fromRGBO(100, 255, 218, 1),
                width: 2.0), // Borde cuando está habilitado
          ),
          focusedBorder: OutlineInputBorder(
            borderRadius: BorderRadius.circular(10.0),
            borderSide: BorderSide(
                color: Colors.tealAccent,
                width: 2.0), // Borde cuando está enfocado
          ),
          // Cambiar el color del texto del hint y el de las opciones seleccionadas
          hintStyle:
              TextStyle(color: Colors.white70), // Color más tenue para el hint
        ),
        items: grupos.map<DropdownMenuItem<int>>((grupo) {
          return DropdownMenuItem<int>(
              value: int.tryParse(grupo['id_curso'].toString()) ?? 0,
              child:
                  Text(grupo['grupo'], style: TextStyle(color: Colors.black)));
        }).toList(),
        onChanged: onChanged,
      ),
    );
  }
}
