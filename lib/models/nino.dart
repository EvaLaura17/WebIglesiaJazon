class Nino {
  final int id; // ID del niño
  final String nombre; // Nombre del niño
  final String apellidoPaterno; // Apellido paterno
  final String apellidoMaterno; // Apellido materno
  final int edad; // Edad del niño

  // Constructor
  Nino({
    required this.id,
    required this.nombre,
    required this.apellidoPaterno,
    required this.apellidoMaterno,
    required this.edad,
  });

  // Método para crear una instancia del modelo desde un JSON
  factory Nino.fromJson(Map<String, dynamic> json) {
    return Nino(
      id: json['id'], // Ajusta el nombre de la clave según el JSON de tu API
      nombre: json[
          'nombre'], // Ajusta el nombre de la clave según el JSON de tu API
      apellidoPaterno: json['apellido_paterno'], // Ajusta el nombre de la clave
      apellidoMaterno: json['apellido_materno'], // Ajusta el nombre de la clave
      edad:
          json['edad'], // Ajusta el nombre de la clave según el JSON de tu API
    );
  }
}
