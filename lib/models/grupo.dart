class Grupo {
  final int id; // ID del grupo
  final String nombre; // Nombre del grupo

  // Constructor
  Grupo({required this.id, required this.nombre});

  // Método para crear una instancia del modelo desde un JSON
  factory Grupo.fromJson(Map<String, dynamic> json) {
    return Grupo(
      id: json[
          'id_curso'], // Ajusta el nombre de la clave según el JSON de tu API
      nombre:
          json['grupo'], // Ajusta el nombre de la clave según el JSON de tu API
    );
  }
}
