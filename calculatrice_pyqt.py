import sys
from PyQt6.QtWidgets import QApplication, QMainWindow, QWidget, QVBoxLayout, QGridLayout, QLineEdit, QPushButton
from PyQt6.QtCore import Qt

class CalculatriceApp(QMainWindow):
    def __init__(self):
        super().__init__()
        
        self.setWindowTitle("Calculatrice Custom Shape")
        self.setFixedSize(340, 460)
        self.setStyleSheet("""QMainWindow {
                background-color: #b0b0b8; }""")
        self.central_widget = QWidget(self)
        self.setCentralWidget(self.central_widget)
        self.main_layout = QVBoxLayout()
        self.main_layout.setContentsMargins(20, 20, 20, 20)
        self.central_widget.setLayout(self.main_layout)
        
        self.ecran = QLineEdit()
        self.ecran.setFixedHeight(55)
        self.ecran.setStyleSheet("""
            QLineEdit {
                background-color: #e5e5ea;
                color: #2c2c2e;
                border: 2px solid #7d4c54; 
                border-radius: 12px;
                font-size: 22px;
                font-weight: bold;
                padding-right: 10px;
            }
        """)
        self.ecran.setAlignment(Qt.AlignmentFlag.AlignRight)
        self.ecran.setReadOnly(True)
        self.main_layout.addWidget(self.ecran)
        
        self.buttons_layout = QGridLayout()
        self.buttons_layout.setSpacing(12)
        self.main_layout.addLayout(self.buttons_layout)
        self.creer_boutons()

    def creer_boutons(self):
        boutons = {
            '7': (0, 0), '8': (0, 1), '9': (0, 2), '/': (0, 3),
            '4': (1, 0), '5': (1, 1), '6': (1, 2), '*': (1, 3),
            '1': (2, 0), '2': (2, 1), '3': (2, 2), '-': (2, 3),
            'C': (3, 0), '0': (3, 1), '=': (3, 2), '+': (3, 3),
        }
        for texte, position in boutons.items():
            bouton = QPushButton(texte)
            bouton.setFixedSize(70, 70) 
            bouton.setStyleSheet("""
                QPushButton {
                    background-color: #e5e5eb;
                    color: #000000;
                    font-size: 18px;
                    font-weight: bold;
                    font-style: italic; 
                    border: 2px solid #7d4c54; 
                    border-top-left-radius: 20px;
                    border-bottom-right-radius: 20px;
                    border-top-right-radius: 5px;
                    border-bottom-left-radius: 5px;
                }
                QPushButton:hover {
                    background-color: #dcdce1;
                }
                QPushButton:pressed {
                    background-color: #cfcfd4;
                }
            """)
            bouton.clicked.connect(lambda checked, t=texte: self.gestion_bouton(t))
            self.buttons_layout.addWidget(bouton, position[0], position[1])
    def gestion_bouton(self, valeur):
        if valeur == 'C':
            self.ecran.clear()
        elif valeur == '=':
            try:
                expression = self.ecran.text()
                resultat = str(eval(expression))
                self.ecran.setText(resultat)
            except Exception:
                self.ecran.setText("Error")
        else:
            texte_actuel = self.ecran.text()
            self.ecran.setText(texte_actuel + valeur)
if __name__ == "__main__":
    app = QApplication(sys.argv)
    fenetre = CalculatriceApp()
    fenetre.show()
    sys.exit(app.exec())